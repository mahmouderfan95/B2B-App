<?php

namespace App\Repositories\Vendor;

use Prettus\Repository\Eloquent\BaseRepository;
use App\Models\Vendor;
use Spatie\Permission\Models\Role;

class SubVendorRepository extends BaseRepository
{


    public function getRelatedSubVendorsToStore($vendor_id): \App\Models\Vendor
    {
        return Vendor::with(['subVendor', 'roles'])->where('id', $vendor_id)->get(['name', 'id'])->first();
    }

    public function store($data_request)
    {
        $sub_vendor = $this->model->create($data_request);
        if ($sub_vendor)
            return $sub_vendor;
        return false;
    }

    public function update($data_request, $sub_vendor_id)
    {
        $sub_vendor = $this->model->find($sub_vendor_id);
        if (!isset($data_request['password']))
                $data_request['password'] = $sub_vendor->password;
        $sub_vendor->update($data_request);
        return $sub_vendor;
    }

    public function show($id)
    {
        return $this->model->find($id);
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
        return "App\Models\SubVendor";
    }

    public function storeRole( $id, $sub_vendor_id)
    {
        $role = Role::with('permissions')->where('id', $id)->first();
        $model = $this->model->find($sub_vendor_id);
        $model->syncRoles($role);
        $model->givePermissionTo($role->permissions);
    }

    public function updateRole($id, $sub_vendor_id)
    {
        $role = Role::with('permissions')->where('id', $id)->first();
        $model = $this->model->find($sub_vendor_id);
        $model->syncRoles($role);
        $model->givePermissionTo($role->permissions);
        return $model;
    }
}
