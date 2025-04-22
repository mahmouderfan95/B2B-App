<?php

namespace App\Services\Admin;

use App\Helpers\FileUpload;
use App\Http\Requests\Admin\SubVendorRequest;
use App\Repositories\Admin\SubVendorRepository;
use App\Repositories\Admin\VendorRepository;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Role;

class SubVendorService
{

    use FileUpload;

    const VENDOR_SUB_VENDORS_INDEX = 'dashboard.sub-vendors.index';
    private $subVendorRepository;
    private $vendorRepository;

    public function __construct(SubVendorRepository $subVendorRepository, VendorRepository $vendorRepository)
    {
        $this->subVendorRepository = $subVendorRepository;
        $this->vendorRepository = $vendorRepository;
    }


    public function getSubVendors()
    {
        try {
            $subVendors = $this->subVendorRepository->all();
            return view('admin.subVendors.index', compact(['subVendors']));
        } catch (Exception $e) {
            return response()->json([
                'status' => 'general_error',
                'message' => __('admin.general_error'),
                'error_message' => $e->getMessage()
            ]);
        }

    }


    public function editSubVendor($id): \Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
    {

        try {
            $subVendor = $this->subVendorRepository->show($id);
            $vendors = $this->vendorRepository->getAllVendors();

            $roles = Role::where('guard_name', 'sub_vendor')->get(['id', 'name']);
            return view("admin.subVendors.edit", compact('subVendor', 'roles', 'vendors'));
        } catch (Exception $e) {
            return response()->json([
                'status' => 'general_error',
                'message' => __('admin.general_error'),
                'error_message' => $e->getMessage()
            ]);
        }
    }


    /**
     * create  Vendors.
     */
    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
    {
        try {
            $roles = Role::where('guard_name', 'sub_vendor')->get(['id', 'name']);
            $vendors = $this->vendorRepository->getAllVendors();
            return view("admin.subVendors.create", compact('roles', 'vendors'));
        } catch (Exception $e) {
            return response()->json([
                'status' => 'general_error',
                'message' => __('admin.general_error'),
                'error_message' => $e->getMessage()
            ]);
        }
    }

    /**
     *
     * Create New Sub Vendor.
     * @param Request $request
     */
    public function store(SubVendorRequest $request)
    {
        try {
            $req = $request->all();
            if (isset($req['password']))
                $req['password'] = bcrypt($req['password']);

            $role = $req['role'];
            $req = Arr::except($req, 'role');
            $vendor = $this->subVendorRepository->store($req);
            $this->subVendorRepository->storeRole($role, $vendor->id);
            if ($vendor)
                return redirect()->route(self::VENDOR_SUB_VENDORS_INDEX)->with('success', true);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'general_error',
                'message' => __('admin.general_error'),
                'error_message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Update Sub Vendor.
     *
     * @param integer $sub_vendor_id
     * @param Request $request
     * @return RedirectResponse | array
     */

    public function updateSubVendor(Request $request, int $sub_vendor_id): RedirectResponse|array
    {
        $req = $request->all();

        if (isset($req['password']))
            $req['password'] = bcrypt($req['password']);
        $role = $request->role;
        $req = Arr::except($req, 'role');

        try {
            $vendor = $this->subVendorRepository->update($req, $sub_vendor_id);
            if ($vendor) {
                $this->subVendorRepository->updateRole($role, $sub_vendor_id);
                return redirect()->route(self::VENDOR_SUB_VENDORS_INDEX)->with('success', true);
            }
        } catch (Exception $e) {
            return [
                'status' => 'general_error',
                'message' => __('admin.general_error'),
                'error_message' => $e->getMessage()
            ];
        }
    }

    /**
     * Delete Vendor.
     *
     * @param int $vendor_id
     * @return RedirectResponse
     */
    public function deleteSubVendor(int $sub_vendor_id): RedirectResponse
    {
        try {
            $sub_vendor = $this->subVendorRepository->show($sub_vendor_id);
            if ($sub_vendor) {
                $this->subVendorRepository->destroy($sub_vendor_id);
                return redirect()->route(self::VENDOR_SUB_VENDORS_INDEX)->with('success', true);
            }
            return redirect()->back();
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }
}
