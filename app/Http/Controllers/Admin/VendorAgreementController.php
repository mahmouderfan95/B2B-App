<?php

namespace App\Http\Controllers\Admin;

use App\Enums\VendorAgreementEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SendAgreementRequest;
use App\Models\Vendor;
use App\Models\VendorAgreement;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class VendorAgreementController extends Controller
{
    public function index(Request $request)
    {

        $vendors = Vendor::all();
        $statuses = VendorAgreementEnum::getStatusesTranslated();

        $status = $request->get("status", "");
        $vendor = $request->get("vendor", "");
        $from = $request->has("from") ? Carbon::parse($request->get('from')) : null;
        $to = $request->has("to") ? Carbon::parse($request->get('to')) : now();

        $collection = VendorAgreement::query()
            ->when($status != '', fn($q) => $q->status($status))
            ->when($vendor != '', fn($q) => $q->vendorId($vendor))
            ->when($from && $to, fn($q) => $q->createdBetween($from, $to))
            ->with(['vendor', 'approvedBy'])
            ->paginate(10);

        return view(
            "admin.vendors-agreements.index",
            compact("collection", "vendors", "statuses")
        );
    }

    public function sendForm(): View
    {

        $vendors = Vendor::all();

        return view("admin.vendors-agreements.send", compact("vendors"));
    }

    public function send(SendAgreementRequest $request): RedirectResponse
    {
        if (VendorAgreement::vendorId($request->get("vendor_id"))->pending()->exists()) {
            return redirect()->back()->with("error", __("admin.vendors-agreements-keys.vendor-has-pending-agreement"));
        }
        VendorAgreement::create($request->validated());
        return redirect(route("dashboard.vendors-agreements.index"))
            ->with("success", __("admin.vendors-agreements-keys.send-agreement-success"));
    }

    public function cancel(VendorAgreement $agreement): RedirectResponse
    {
        if ($agreement->status != VendorAgreementEnum::PENDING) {
            return redirect()->back()->with("error", __("admin.vendors-agreements-keys.cant-cancel-agreement"));
        }
        $agreement->update(['status' => VendorAgreementEnum::CANCELED]);
        return redirect()->back()->with("success", __("admin.vendors-agreements-keys.canceled-agreement"));
    }

    public function resend(VendorAgreement $agreement): RedirectResponse
    {
        if ($agreement->status != VendorAgreementEnum::CANCELED) {
            return redirect()->back()->with("error", __("admin.vendors-agreements-keys.cant-resend-agreement"));
        }
        if (VendorAgreement::vendorId($agreement->vendor_id)->where("id", "!=", $agreement->id)->pending()->exists()) {
            return redirect()->back()->with("error", __("admin.vendors-agreements-keys.vendor-has-pending-agreement"));
        }
        $agreement->update(['status' => VendorAgreementEnum::PENDING]);
        return redirect()->back()->with("success", __("admin.vendors-agreements-keys.resent-agreement"));
    }
}
