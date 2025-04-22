<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\FrontPageService;
use Illuminate\Http\Request;
use Prettus\Repository\Exceptions\RepositoryException;

class PrivacyPolicyController extends Controller
{
    public function __construct(FrontPageService $service)
    {
        $this->service = $service;
        $this->service->setModel('App\Models\PrivacyPolicy');
        $this->service->setForeignKey('privacy_policy_id');
    }

    public function index()
    {
        return $this->service->index('admin.privacy_policy.index');
    }

    public function create()
    {
        return $this->service->create('admin.privacy_policy.create');
    }

    public function store(Request $request)
    {
        return $this->service->store($request, 'dashboard.privacy-policy.index');
    }

    public function edit($id)
    {
        return $this->service->edit($id, 'admin.privacy_policy.edit');
    }

    /**
     * @throws RepositoryException
     */
    public function update(Request $request, int $id)
    {
        return $this->service->update($request, $id, 'dashboard.privacy-policy.index');
    }

    public function destroy(Request $request, int $id)
    {
        return $this->service->destroy($id, 'dashboard.privacy-policy.index');
    }
}
