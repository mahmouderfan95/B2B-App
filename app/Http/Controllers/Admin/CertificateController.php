<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CertificateRequest;
use App\Services\Admin\CertificateService;

class CertificateController extends Controller
{
    public $certificateService;

    /**
     * Certificate  Constructor.
     */
    public function __construct(CertificateService $certificateService)
    {
        $this->certificateService = $certificateService;
    }


    /**
     * All Cats
     */
    public function index(Request $request)
    {
        return $this->certificateService->getAllCertificates($request);
    }

    /**
     * create certificate page
     */
    public function create()
    {
        return $this->certificateService->create();
    }

    /**
     *  Store Certificate
     */
    public function store(CertificateRequest $request)
    {

        return $this->certificateService->storeCertificate($request);
    }

    /**
     * show the certificate..
     *
     */
    public function show( $id)
    {
        return'dd';
    }

    /**
     * edit the certificate..
     *
     */
    public function edit(int $id)
    {
        return $this->certificateService->edit($id);

    }

    /**
     * Update the certificate..
     *
     */
    public function update(CertificateRequest $request, int $id)
    {
        return $this->certificateService->updateCertificate($request,$id);
    }
    /**
     *
     * Delete Certificate Using ID.
     *
     */
    public function destroy(int $id)
    {
        return $this->certificateService->deleteCertificate($id);

    }

}
