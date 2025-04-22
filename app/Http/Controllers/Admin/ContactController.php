<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ContactUsRequest;
use App\Services\Admin\FrontPageService;
use Illuminate\Http\Request;
use Prettus\Repository\Exceptions\RepositoryException;

class ContactController extends Controller
{

    public function __construct(FrontPageService $service)
    {
        $this->service = $service;
        $this->service->setModel('App\Models\Contact');
        $this->service->setForeignKey('contact_id');
    }

    public function index()
    {
        return $this->service->index('admin.contact.index');
    }

    public function create()
    {
        return $this->service->create('admin.contact.create');
    }

    public function store(Request $request)
    {
        return $this->service->store($request, 'dashboard.contact.index');
    }

    public function edit($id)
    {
        return $this->service->edit($id, 'admin.contact.edit');
    }

    /**
     * @throws RepositoryException
     */
    public function update(Request $request, int $id)
    {
        return $this->service->update($request, $id, 'dashboard.contact.index');
    }

    public function destroy(Request $request, int $id)
    {
        return $this->service->destroy($id, 'dashboard.contact.index');
    }
}
