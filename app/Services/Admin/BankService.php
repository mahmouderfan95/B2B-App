<?php

namespace App\Services\Admin;

use App\Helpers\FileUpload;
use App\Http\Requests\Admin\BankRequest;
use App\Repositories\Admin\BankRepository;
use App\Repositories\Admin\LanguageRepository;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BankService
{

    use FileUpload;
    private $bankRepository;
    private $languageRepository;

    public function __construct(BankRepository $bankRepository,LanguageRepository $languageRepository)
    {
        $this->bankRepository = $bankRepository;
        $this->languageRepository = $languageRepository;
    }

    /**
     *
     * All  Banks.
     *
     */
    public function getAllBanks($request): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $banks  = $this->bankRepository->getAllBanks($request);
            return view("admin.banks.index", compact('banks'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }

    /**
     * create  Banks.
     */
    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $languages  = $this->languageRepository->all();
            return view("admin.banks.create",compact('languages'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }

    /**
     *
     * Create New Bank.
     *
     * @return RedirectResponse
     */
    public function storeBank(BankRequest $request): RedirectResponse
    {
        $data_request = $request->except('image');
        if (isset($request->image))
            $data_request['image'] = $this->save_file($request->image,'banks');

        try {
            $bank = $this->bankRepository->store($data_request);
            if ($bank)
                return redirect()->route('dashboard.banks.index')->with('success', true);
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }



    /**
     * edit  Languages.
     */
    public function edit($id)
    {
        try {
            $bank = $this->bankRepository->show($id);
            $languages  = $this->languageRepository->all();
            return view("admin.banks.edit",compact('bank','languages'));
        } catch (Exception $e) {
            return redirect()->route('dashboard.banks.index');
        }
    }

    /**
     * Update Bank.
     *
     * @param integer $bank_id
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateBank(BankRequest $request,int $bank_id): RedirectResponse
    {
        $data_request = $request->except('image');
        if (isset($request->image))
            $data_request['image'] = $this->save_file($request->image,'banks');

        try {
            $bank = $this->bankRepository->update($data_request,$bank_id);
            if ($bank)
                return redirect()->route('dashboard.banks.index')->with('success', true);
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }

    /**
     * Delete Bank.
     *
     * @param int $bank_id
     * @return RedirectResponse
     */
    public function deleteBank(int $bank_id): RedirectResponse
    {
        try {
            $bank = $this->bankRepository->show($bank_id);
            if ($bank)
            {
                $this->bankRepository->destroy($bank_id);
                return redirect()->route('dashboard.banks.index')->with('success', true);
            }
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }
}
