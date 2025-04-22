<?php

namespace App\Http\Controllers\SubVendor;

use App\Enums\VendorAgreementEnum;
use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Services\VendorAgreement;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Exception;
class AgreementController extends Controller
{
    public function __construct(
        private VendorAgreement $agreementService
    ) {}

    public function index() : View {
        $vendor = Vendor::find(auth('sub_vendor')->user()->vendor_id);
        $collection = $vendor->agreements()->paginate(15);
        return view("sub-vendor.agreements.index", ['collection' => $collection]);
    }

    public function approve() : RedirectResponse {
        $vendor = Vendor::find(auth('sub_vendor')->user()->vendor_id);
        // $agreement = $user->type == UserTypes::VENDOR ? $user->vendor->agreements()->pending()->first() : null;
        $agreement = $vendor->agreements()->pending()->first();

        if (is_null($agreement)) {
            return redirect()->back()->with("error", __("vendors.no-agreement-requested"));
        }

        try {
            DB::beginTransaction();
            $agreement->update([
                "status" => VendorAgreementEnum::APPROVED,
                "approved_by" => $vendor->id,
                "approved_at" => now()->toDateTimeString(),
                "approved_pdf" => $this->agreementService->fillPdfFile($agreement->agreement_pdf_path, $vendor)
            ]);
            DB::commit();
        } catch (Exception $e) {
            $msg = $e->getMessage();
            DB::rollBack();
            Log::error("agreement_id: {$agreement->id} Vendor Agreement Exception: ". $msg);
            $error = __("vendors.cant-approved-agreement");
            if (Str::contains($msg, "FPDI")) $error .= " $msg";
            return redirect()->back()->with("error", $error);
        }

        return redirect()->back()->with("success", __("vendors.you-have-approved-agreement"));
    }
}
