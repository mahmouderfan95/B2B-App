<?php

namespace App\Services\Admin;

use App\Helpers\FileUpload;
use App\Http\Requests\Admin\ClientRequest;
use App\Repositories\Admin\BankRepository;
use App\Repositories\Admin\ClientRepository;
use App\Repositories\Admin\CountryRepository;
use App\Repositories\Admin\LanguageRepository;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClientService
{

    use FileUpload;

    private $clientRepository;
    private $languageRepository;
    private $countryRepository;
    private $bankRepository;

    public function __construct(ClientRepository $clientRepository, LanguageRepository $languageRepository, CountryRepository $countryRepository, BankRepository $bankRepository)
    {
        $this->clientRepository = $clientRepository;
        $this->languageRepository = $languageRepository;
        $this->countryRepository = $countryRepository;
        $this->bankRepository = $bankRepository;
    }

    /**
     *
     * All  Clients.
     *
     */
    public function getAllClients($request): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $clients = $this->clientRepository->getAllClients($request);
            return view("admin.clients.index", compact('clients'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }

    /**
     * create  Clients.
     */
    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            return view("admin.clients.create");
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }

    /**
     * show  Clients.
     */
    public function show($id): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $client = $this->clientRepository->show($id);
            return view("admin.clients.show", compact('client'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }

    /**
     *
     * Create New Client.
     *
     * @return RedirectResponse
     */
    public function storeClient(ClientRequest $request): RedirectResponse
    {
        $data_request = $request->except('image');
        if (isset($request->image))
            $data_request['image'] = $this->save_file($request->image, 'clients');

        $data_request['password'] = Hash::make($request->password);
        try {
            $client = $this->clientRepository->store($data_request);
            if ($client)
                return redirect()->route('dashboard.clients.index')->with('success', true);
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }


    /**
     * edit  clients
     */
    public function edit($id)
    {
        try {
            $client = $this->clientRepository->show($id);
            return view("admin.clients.edit", compact('client'));
        } catch (Exception $e) {
            return redirect()->route('dashboard.clients.index');
        }
    }

    /**
     * Update Client.
     *
     * @param integer $client_id
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateClient(ClientRequest $request, int $client_id): RedirectResponse
    {
        $data_request = $request->except('image');

        if (isset($request->image))
            $data_request['image'] = $this->save_file($request->image, 'clients');

        if (isset($request->password))
            $data_request['password'] = Hash::make($request->password);

        try {
            $client = $this->clientRepository->update($data_request, $client_id);
            if ($client)
                return redirect()->route('dashboard.clients.index')->with('success', true);
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }

    /**
     * Delete Client.
     *
     * @param int $client_id
     * @return RedirectResponse
     */
    public function deleteClient(int $client_id): RedirectResponse
    {
        try {
            $client = $this->clientRepository->show($client_id);
            if ($client) {
                $this->clientRepository->destroy($client_id);
                return redirect()->route('dashboard.clients.index')->with('success', true);
            }
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }
}
