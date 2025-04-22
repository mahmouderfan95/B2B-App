<?php

namespace App\Repositories\Admin;

use Prettus\Repository\Eloquent\BaseRepository;

class VendorRepository extends BaseRepository
{


    public function getAllVendors()
    {
        return $this->model->paginate(10);
    }

    public function store($data_request)
    {
        $vendor = $this->model->create($data_request);
        if ($vendor)
            return $vendor;

        return false;
    }

    public function update($data_request, $vendor_id)
    {
        $vendor = $this->model->find($vendor_id);
        $vendor->update($data_request);
        return $vendor;
    }

    public function show($id)
    {
        return $this->model->find($id);
    }
    public function banned($id)
    {
        $vendor =  $this->model->find($id);
        $vendor->banned = $vendor->banned == 0 ? 1 : 0;
        $vendor->save();
        return $vendor;
    }

    public function destroy($id)
    {
        return $this->model->where('id', $id)->delete();
    }

    /**
     * Vendor Model
     *
     * @return string
     */
    public function model(): string
    {
        return "App\Models\Vendor";
    }
}
