<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\FastShippingServices;
use App\Services\Admin\FrontPageService;
use Illuminate\Http\Request;

class FastShippingController extends Controller
{
    public function __construct(FrontPageService $service)
    {
        $this->service = $service;
        $this->service->setModel('App\Models\FastShipping');
        $this->service->setForeignKey('fast_shipping_id');
    }
    public function index()
    {
        return $this->service->index('admin.fast_shipping.index');
    }

    public function create()
    {
        return $this->service->create('admin.fast_shipping.create');
    }

    public function store(Request $request)
    {
        return $this->service->store($request, 'dashboard.fast-shipping.index');
    }

    public function edit($id)
    {
        return $this->service->edit($id,'admin.fast_shipping.edit');
    }

    /**
     * @throws RepositoryException
     */
    public function update(Request $request, int $id)
    {
        return $this->service->update($request, $id, 'dashboard.fast-shipping.index');
    }

    public function destroy(Request $request, int $id)
    {
        return $this->service->destroy($id, 'dashboard.fast-shipping.index');
    }
}
