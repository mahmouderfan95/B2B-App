<?php

namespace App\Services\Admin;

use App\Http\Requests\Admin\CertificateRequest;
use App\Models\Certificate;
use App\Repositories\Admin\CertificateRepository;
use App\Repositories\Admin\LanguageRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Exception;
use App\Helpers\FileUpload;
class CertificateService
{

    use FileUpload;
    private $certificateRepository;
    private $languageRepository;

    public function __construct(CertificateRepository $certificateRepository,LanguageRepository $languageRepository)
    {
        $this->certificateRepository = $certificateRepository;
        $this->languageRepository = $languageRepository;
    }

    /**
     *
     * All  Certificates.
     *
     */
    public function getAllCertificates($request): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $certificates  = $this->certificateRepository->getAllCertificates($request);
            return view("admin.certificates.index", compact('certificates'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }

    /**
     * create  Certificates.
     */
    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $languages  = $this->languageRepository->all();
            return view("admin.certificates.create",compact('languages'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }

    /**
     *
     * Create New Certificate.
     *
     * @return RedirectResponse
     */
    public function storeCertificate(CertificateRequest $request): RedirectResponse
    {
        $data_request = $request->except('image');
        if (isset($request->image))
            $data_request['image'] = $this->save_file($request->image,'certificates');

        try {
            $certificate = $this->certificateRepository->store($data_request);
            if ($certificate)
                return redirect()->route('dashboard.certificates.index')->with('success', true);
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
            $certificate = $this->certificateRepository->show($id);
            $languages  = $this->languageRepository->all();
            return view("admin.certificates.edit",compact('certificate','languages'));
        } catch (Exception $e) {
            return redirect()->route('dashboard.certificates.index');
        }
    }

    /**
     * Update Certificate.
     *
     * @param integer $certificate_id
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateCertificate(CertificateRequest $request,int $certificate_id): RedirectResponse
    {
        $data_request = $request->except('image');
        if (isset($request->image))
            $data_request['image'] = $this->save_file($request->image,'certificates');

        try {
            $certificate = $this->certificateRepository->update($data_request,$certificate_id);
            if ($certificate)
                return redirect()->route('dashboard.certificates.index')->with('success', true);
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }

    /**
     * Delete Certificate.
     *
     * @param int $certificate_id
     * @return RedirectResponse
     */
    public function deleteCertificate(int $certificate_id): RedirectResponse
    {
        try {
            $certificate = $this->certificateRepository->show($certificate_id);
            if ($certificate)
            {
                $this->certificateRepository->destroy($certificate_id);
                return redirect()->route('dashboard.certificates.index')->with('success', true);
            }
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }
}
