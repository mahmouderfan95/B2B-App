<?php

namespace App\Services\SubVendor;

use App\Helpers\FileUpload;
use App\Http\Requests\Vendor\SubVendorRequest;
use App\Repositories\SubVendor\SubVendorRepository;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Role;

class SubVendorService
{

    use FileUpload;

    const VENDOR_SUB_VENDORS_INDEX = 'sub-vendor.sub.list';
    private $subVendorRepository;


    public function __construct(SubVendorRepository $subVendorRepository)
    {
        $this->subVendorRepository = $subVendorRepository;
    }


    public function getSubVendors()
    {
        try {
            $vendor = $this->getRelatedSubVendorsToStore(auth()->guard('sub_vendor')->user()->vendor_id);
            return view('sub-vendor.subVendors.index', compact(['vendor']));
        } catch (Exception $e) {
            return response()->json([
                'status' => 'general_error',
                'message' => __('admin.general_error'),
                'error_message' => $e->getMessage()
            ]);
        }

    }

    /**
     * @return mixed
     */
    public function getRelatedSubVendorsToStore($store_id)
    {
        return $this->subVendorRepository->getRelatedSubVendorsToStore($store_id);
    }


    public function editSubVendor($id): \Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
    {

        try {
            $subVendor = $this->subVendorRepository->show($id);
            $roles = Role::where('guard_name', 'sub_vendor')->get(['id', 'name']);
            return view("sub-vendor.subVendors.edit", compact('subVendor', 'roles'));
        } catch (Exception $e) {
            return response()->json([
                'status' => 'general_error',
                'message' => __('admin.general_error'),
                'error_message' => $e->getMessage()
            ]);
        }
    }

    public function SubVendorProfile(): \Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
    {
        try {
            $subVendor = auth()->user();
            return view("sub-vendor.subVendors.edit", compact('subVendor'));
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
            return view("sub-vendor.subVendors.create")->with('roles', $roles);
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
            $req['vendor_id'] = auth()->user()->id;
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
                if (auth()->guard('vendor')->check()) {

                    $this->subVendorRepository->updateRole($role, $sub_vendor_id);
                }
                return redirect()->route('sub-vendor.sub.list')->with('success', true);
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
