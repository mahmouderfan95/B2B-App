<?php

namespace App\Repositories\Front;


use App\Models\Vendor;
use Prettus\Repository\Eloquent\BaseRepository;
use Spatie\Permission\Models\Role;

class VendorRepository extends BaseRepository
{


    public function getAllVendors()
    {
        return $this->model->approved()->paginate(10);
    }


    public function details($id)
    {
        return $this->model->approved()
        ->find($id);
    }
    public function products($id)
    {
        return $this->model->approved()->where('id',$id)->with('products')->paginate(10);
    }

    public function storeRole( $id, $vendor_id)
    {
        $role = Role::with('permissions')->where('id', $id)->first();
        $model = $this->model->find($vendor_id);
        $model->syncRoles($role);
        $model->givePermissionTo($role->permissions);
    }

    public function register($data_request)
    {
        return $this->model->create($data_request);
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
