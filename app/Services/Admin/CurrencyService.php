<?php

namespace App\Services\Admin;

use App\Http\Requests\Admin\CurrencyRequest;
use App\Http\Resources\Admin\CurrencyResource;
use App\Repositories\Admin\CurrencyRepository;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Helpers\FileUpload;
class CurrencyService
{
    use FileUpload;
    private $currencyRepository;

    public function __construct(CurrencyRepository $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    /**
     *
     * All  Currencies.
     *
     */
    public function getAllCurrencies($request): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $currencies = $this->currencyRepository->getAllCurrencies($request);
            return view("admin.currencies.index", compact('currencies'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }

    /**
     * create  Currencies.
     */
    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            return view("admin.currencies.create");
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }

    /**
     * Create New Currency.
     *
     * @param CurrencyRequest $request
     * @return RedirectResponse
     */
    public function storeCurrency(CurrencyRequest $request): RedirectResponse
    {
        $data_request = $request->all();
        try {
            $currency = $this->currencyRepository->store($data_request);
            if ($currency)
                return redirect()->route('dashboard.currencies.index')->with('success', true);
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }


    /**
     * edit  Currencies.
     */
    public function edit($id): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        try {
            $currency = $this->currencyRepository->show($id);
            return view("admin.currencies.edit",compact('currency'));
        } catch (Exception $e) {
            return view("admin.currencies.index");
        }
    }
    /**
     * Update Currency.
     *
     * @param integer $currency_id
     * @param Request $request
     * @return array
     * @throws ValidatorException
     */
    public function updateCurrency(CurrencyRequest $request, int $currency_id): RedirectResponse
    {
        $data_request = $request->all();
        try {
            $currency = $this->currencyRepository->update($data_request,$currency_id);
            if ($currency)
                return redirect()->route('dashboard.currencies.index')->with('success', true);
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }

    /**
     * Delete Currency.
     *
     * @param int $currency_id
     * @return RedirectResponse
     */
    public function deleteCurrency(int $currency_id): RedirectResponse
    {
        try {
            $currency = $this->currencyRepository->show($currency_id);
            if ($currency)
            {
                $this->remove_file('currencies',$currency->name);
                $this->currencyRepository->destroy($currency_id);
                return redirect()->route('dashboard.currencies.index')->with('success', true);
            }
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error','message' => __('admin.general_error')]);
        }

    }
}
