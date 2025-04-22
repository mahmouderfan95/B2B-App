<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ClientRequest;
use App\Services\Admin\ClientService;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public $clientService;

    /**
     * Client  Constructor.
     */
    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }


    /**
     * All Cats
     */
    public function index(Request $request)
    {
        return $this->clientService->getAllClients($request);
    }

    /**
     * create client page
     */
    public function create()
    {
        return $this->clientService->create();
    }

    /**
     *  Store Client
     */
    public function store(ClientRequest $request)
    {

        return $this->clientService->storeClient($request);
    }

    /**
     * show the client
     *
     */
    public function show($id)
    {
        return $this->clientService->show($id);
    }

    /**
     * edit the client..
     *
     */
    public function edit(int $id)
    {
        return $this->clientService->edit($id);

    }

    /**
     * Update the client
     *
     */
    public function update(ClientRequest $request, int $id)
    {
        return $this->clientService->updateClient($request, $id);
    }

    /**
     *
     * Delete Client Using ID.
     *
     */
    public function destroy(int $id)
    {
        return $this->clientService->deleteClient($id);

    }

}
