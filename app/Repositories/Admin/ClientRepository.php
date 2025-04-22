<?php

namespace App\Repositories\Admin;

use Prettus\Repository\Eloquent\BaseRepository;

class ClientRepository extends BaseRepository
{


    public function getAllClients(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->all();
    }

    public function store($data_request)
    {
        $client = $this->model->create($data_request);
        if ($client)
            return $client;

        return false;
    }

    public function update($data_request, $client_id)
    {
        $client = $this->model->find($client_id);
        $client->update($data_request);
        return $client;
    }

    public function show($id)
    {
        return $this->model->where('id',$id)->with('client_addresses')->first();
    }
    public function banned($id)
    {
        $client =  $this->model->find($id);
        $client->banned = 1;
        $client->save();
        return $client;
    }

    public function destroy($id)
    {
        return $this->model->where('id', $id)->delete();
    }

    /**
     * Client Model
     *
     * @return string
     */
    public function model(): string
    {
        return "App\Models\Client";
    }
}
