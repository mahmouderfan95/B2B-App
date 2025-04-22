<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\FrontPageService;
use Illuminate\Http\Request;
use Prettus\Repository\Exceptions\RepositoryException;

class TermsAndConditionController extends Controller
{
    public function __construct(FrontPageService $service)
    {
        $this->service = $service;
        $this->service->setModel('App\Models\TermAndCondition');
        $this->service->setForeignKey('term_and_condition_id');
    }

    public function index()
    {
        return $this->service->index('admin.terms_condition.index');
    }

    public function create()
    {
        return $this->service->create('admin.terms_condition.create');
    }

    public function store(Request $request)
    {
        return $this->service->store($request, 'dashboard.terms-conditions.index');
    }

    public function edit($id)
    {
        return $this->service->edit($id, 'admin.terms_condition.edit');
    }

    /**
     * @throws RepositoryException
     */
    public function update(Request $request, int $id)
    {
        
        return $this->service->update($request, $id, 'dashboard.terms-conditions.index');
    }

    public function destroy(Request $request, int $id)
    {
        return $this->service->destroy($id, 'dashboard.terms-conditions.index');
    }
}
