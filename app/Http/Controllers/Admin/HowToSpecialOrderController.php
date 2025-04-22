<?php

namespace App\Http\Controllers\Admin;
use App\Services\Admin\FrontPageService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HowToSpecialOrderController extends Controller
{
    public function __construct(FrontPageService $service)
    {
        $this->service = $service;
        $this->service->setModel('App\Models\HowToSpecialOrder');
        $this->service->setForeignKey('how_to_sp_order_id');
    }
    public function index()
    {
        return $this->service->index('admin.how_to_sp_order.index');
    }

    public function create()
    {
        return $this->service->create('admin.how_to_sp_order.create');
    }

    public function store(Request $request)
    {
        return $this->service->store($request, 'dashboard.how-to-special-order.index');
    }

    public function edit($id)
    {
        return $this->service->edit($id,'admin.how_to_sp_order.edit');
    }

    /**
     * @throws RepositoryException
     */
    public function update(Request $request, int $id)
    {
        return $this->service->update($request, $id, 'dashboard.how-to-special-order.index');
    }

    public function destroy(Request $request, int $id)
    {
        return $this->service->destroy($id, 'dashboard.how-to-special-order.index');
    }
}
