<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\FrontPageService;
use Illuminate\Http\Request;

class HowToNegotiatePriceController extends Controller
{
    public function __construct(FrontPageService $service)
    {
        $this->service = $service;
        $this->service->setModel('App\Models\HowToNegotiatePrice');
        $this->service->setForeignKey('how_to_negotiate_id');
    }
    public function index()
    {
        return $this->service->index('admin.how_to_negotiate.index');
    }

    public function create()
    {
        return $this->service->create('admin.how_to_negotiate.create');
    }

    public function store(Request $request)
    {
        return $this->service->store($request, 'dashboard.how-to-negotiate-price.index');
    }

    public function edit($id)
    {
        return $this->service->edit($id,'admin.how_to_negotiate.edit');
    }

    /**
     * @throws RepositoryException
     */
    public function update(Request $request, int $id)
    {
        return $this->service->update($request, $id, 'dashboard.how-to-negotiate-price.index');
    }

    public function destroy(Request $request, int $id)
    {
        return $this->service->destroy($id, 'dashboard.how-to-negotiate-price.index');
    }
}
