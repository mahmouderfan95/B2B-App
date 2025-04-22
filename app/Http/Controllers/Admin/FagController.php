<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\FrontPageService;
use Illuminate\Http\Request;
use App\Http\Requests;
use Prettus\Repository\Exceptions\RepositoryException;


/**
 * Class FagsController.
 *
 * @package namespace App\Http\Controllers\Admin;
 */
class FagController extends Controller
{

    public function __construct(FrontPageService $service)
    {
        $this->service = $service;
        $this->service->setModel('App\Models\Fag');
        $this->service->setForeignKey('fag_id');
    }

    public function index()
    {
        return $this->service->index('admin.fags.index');
    }

    public function create()
    {
        return $this->service->create('admin.fags.create');
    }

    public function store(Request $request)
    {
        return $this->service->store($request, 'dashboard.fags.index');
    }

    public function edit($id)
    {
        return $this->service->edit($id, 'admin.fags.edit');
    }

    /**
     * @throws RepositoryException
     */
    public function update(Request $request, int $id)
    {
        return $this->service->update($request, $id, 'dashboard.fags.index');
    }

    public function destroy(Request $request, int $id)
    {
        return $this->service->destroy($id, 'dashboard.fags.index');
    }
}
