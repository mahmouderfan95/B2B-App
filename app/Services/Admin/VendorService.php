<?php

namespace App\Services\Admin;

use App\Helpers\FileUpload;
use App\Http\Requests\Admin\VendorRequest;
use App\Models\Vendor;
use App\Models\VendorWallet;
use App\Models\VendorWalletTransaction;
use App\Repositories\Admin\BankRepository;
use App\Repositories\Admin\CountryRepository;
use App\Repositories\Admin\LanguageRepository;
use App\Repositories\Admin\VendorRepository;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VendorService
{

    use FileUpload;

    private $vendorRepository;
    private $languageRepository;
    private $countryRepository;
    private $bankRepository;

    public function __construct(VendorRepository $vendorRepository, LanguageRepository $languageRepository, CountryRepository $countryRepository, BankRepository $bankRepository)
    {
        $this->vendorRepository = $vendorRepository;
        $this->languageRepository = $languageRepository;
        $this->countryRepository = $countryRepository;
        $this->bankRepository = $bankRepository;
    }

    /**
     *
     * All  Vendors.
     *
     */
    public function getAllVendors($request): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $vendors = $this->vendorRepository->getAllVendors($request);
            return view("admin.vendors.index", compact('vendors'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }

    /**
     * create  Vendors.
     */
    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            return view("admin.vendors.create");
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }

    /**
     *
     * Create New Vendor.
     *
     * @return RedirectResponse
     */
    public function storeVendor(VendorRequest $request): RedirectResponse
    {
        $data_request = $request->except('logo');
        if (isset($request->image))
            $data_request['logo'] = $this->save_file($request->image, 'vendors');

        try {
            $vendor = $this->vendorRepository->store($data_request);
            if ($vendor)
                return redirect()->route('dashboard.vendors.index')->with('success', true);
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }


    /**
     * edit  vendors
     */
    public function edit($id)
    {
        try {
            $banks = $this->getBanksForm();
            $countries = $this->getAllCountriesForm();
            $vendor = $this->vendorRepository->show($id);
            return view("admin.vendors.edit", compact('vendor', 'banks', 'countries'));
        } catch (Exception $e) {
            return $e->getMessage();
            return redirect()->route('dashboard.vendors.index');
        }
    }

    /**
     * edit  vendors
     */
    public function banned($id)
    {
        try {
            $vendor = $this->vendorRepository->show($id);
            if (isset($vendor))
                $vendor_banned = $this->vendorRepository->banned($id);

            return redirect()->route('dashboard.vendors.index')->with('success', true);
        } catch (Exception $e) {
            return redirect()->route('dashboard.vendors.index');
        }
    }

    /**
     * Update Vendor.
     *
     * @param integer $vendor_id
     * @param Request $request
     * @return RedirectResponse
     */

    public function updateVendor(VendorRequest $request, int $vendor_id, $destination = 'dashboard.vendors.index'): RedirectResponse

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

        try {
            $vendor = $this->vendorRepository->update($data_request, $vendor_id);
            if ($vendor)
                return redirect()->route($destination)->with('success', true);
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }

    /**
     * Delete Vendor.
     *
     * @param int $vendor_id
     * @return RedirectResponse
     */
    public function deleteVendor(int $vendor_id): RedirectResponse
    {
        try {
            $vendor = $this->vendorRepository->show($vendor_id);
            if ($vendor) {
                $this->vendorRepository->destroy($vendor_id);
                return redirect()->route('dashboard.vendors.index')->with('success', true);
            }
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getBanksForm(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->bankRepository->getAllBanksForm();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllCountriesForm(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->countryRepository->getAllCountriesForm();
    }


    public function addBalance(Request $request)
    {
        $wallet = VendorWallet::where('vendor_id',$request->vendor_id)->first();
        $wallet->update(['balance' => $wallet->balance + $request->balance]);
        // create vendor wallet transaction
        $transaction = VendorWalletTransaction::create([
            'vendor_wallet_id' => $wallet->id,
            'amount' => $wallet->balance,
            'operation_type' => 'in',
            'admin_id' => auth('web')->user()->id
        ]);
        return redirect()->back()->with(['status' => 'success', 'message' => __('admin.success_message')]);
    }

    public function deductionBalance(Request $request)
    {
        $wallet = VendorWallet::where('vendor_id',$request->vendor_id)->first();
        $wallet->update(['balance' => $wallet->balance - $request->balance]);
        // create vendor wallet transaction
        $transaction = VendorWalletTransaction::create([
            'vendor_wallet_id' => $wallet->id,
            'amount' => $wallet->balance,
            'operation_type' => 'out',
            'admin_id' => auth('web')->user()->id
        ]);
        return redirect()->back()->with(['status' => 'success', 'message' => __('admin.success_message')]);


    }

}
