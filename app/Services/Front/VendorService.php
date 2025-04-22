<?php

namespace App\Services\Front;

use App\Http\Requests\Front\VendorRequest;
use App\Http\Resources\Front\SingleProduct;
use App\Http\Resources\Front\VendorResource;
use App\Repositories\Front\VendorRepository;
use Exception;
use App\Helpers\FileUpload;
use App\Http\Resources\Front\Vendors\SingleVendorResource;
use App\Http\Resources\Front\Vendors\VendorAll;
use App\Http\Resources\Front\Vendors\VendorAllResource;
use App\Models\Product;
use App\Models\Vendor;
use App\Traits\ApiResponseAble;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class VendorService
{
    use FileUpload, ApiResponseAble;

    private $vendorRepository;

    public function __construct(VendorRepository $vendorRepository)
    {
        $this->vendorRepository = $vendorRepository;
    }

    /**
     *
     * All  Vendors.
     *
     */
    public function getAllVendors($request): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        $perPage = request()->input('per_page',15);
        $vendors = Vendor::paginate($perPage);
        if (isset($vendors) && count($vendors) > 0) {
            return setResponseApi(true,200,'success message',new SingleVendorResource($vendors));
        } else {
            return $this->listResponse([]);
        }

    }
    public function details($request, $id): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        $lang = $request->header('lang') ?? 'ar';
        app()->setLocale($lang);
        $vendor = $this->vendorRepository->details($id);

        try {
            $vendor = new VendorResource($vendor);

            if (isset($vendor)) {
                return $this->listResponse($vendor);
            } else {
                return $this->listResponse([]);
            }
        } catch (Exception $e) {
            return $this->ApiErrorResponse();
        }
    }

    public function products($request, $id): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        $lang = $request->header('lang') ?? 'ar';
        app()->setLocale($lang);
        $perPage = $request->per_page ?? 15;
        $products = Product::where('vendor_id',$id)->paginate($perPage);
        try {
            if (count($products) > 0) {
                return setResponseApi(true,200,'success message',new SingleProduct($products));
            } else {
                return $this->listResponse([]);
            }
        } catch (Exception $e) {
            return $this->ApiErrorResponse();
        }
    }

    /**
     * edit  Vendors.
     */
    public function register(VendorRequest $request): \Illuminate\Http\JsonResponse
    {
        $data_request = $request->except(['logo', 'image_commercial', 'image_iban', 'image_mark', 'image_tax']);
        if (isset($request->logo))
            $data_request['logo'] = $this->save_file($request->logo, 'vendors');

        if (isset($request->image_commercial))
            $data_request['image_commercial'] = $this->save_file($request->image_commercial, 'vendors');

        if (isset($request->image_iban))
            $data_request['image_iban'] = $this->save_file($request->image_iban, 'vendors');

        if (isset($request->image_mark))
            $data_request['image_mark'] = $this->save_file($request->image_mark, 'vendors');

        if (isset($request->image_tax))
            $data_request['image_tax'] = $this->save_file($request->image_tax, 'vendors');

        $data_request['password'] = Hash::make($request->password);

        try {
            $vendor =  new VendorResource($this->vendorRepository->register($data_request));
            $role = Role::where('guard_name','vendor')->first();
            $this->vendorRepository->storeRole($role->id,$vendor->id);
            if (isset($vendor))
                return $this->ApiSuccessResponse($vendor,trans('api.Ok'));

            return $this->ApiErrorResponse();
        } catch (Exception $e) {
            return $this->ApiErrorResponse();
        }
    }
}
