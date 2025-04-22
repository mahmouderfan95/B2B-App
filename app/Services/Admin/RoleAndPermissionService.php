<?php

namespace App\Services\Admin;

use App\Repositories\Admin\RoleAndPermissionRepository;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionService
{
    public string $guard_name;
    public Model $model;
    public function __construct( public RoleAndPermissionRepository $repo ) {}

    public function setGuard( string $guard_name): void
    {
        $this->guard_name = $guard_name;
    }

    public function setModel( Model $model ): void
    {
        $this->model = $model;
    }

    public function addRole($request)
    {
        $role = $this->repo->addRole($request->role_name, $this->guard_name);
    }

    public function createOrGetPermissions($request)
    {
        $role = $this->repo->addRole($request->permissions, $this->guard_name);
    }

    public function editRole(string $roleName)
    {
        $role = $this->repo->addRole($roleName, $this->guard_name);
    }

    public function deleteRole(string $roleName)
    {
        $role = $this->repo->addRole($roleName, $this->guard_name);
    }



    public function addRoleWithPermissions (string $roleName, array $permissions): Model
    {
        // Create Role
        $role = $this->repo->addRole($roleName, $this->guard_name);

        // Create Permissions
        $this->createPermissions($permissions);
        // Assign Permissions To The Role
        $role->givePermissionTo($permissions);

        $this->model->assignRole($role);
        $this->model->givePermissionTo($permissions);

        return $this->model;
    }

    /**
     * @param string $roleName
     * @return \Illuminate\Database\Eloquent\Builder|Model
     */


    /**
     * @param array $permissions
     * @return void
     */
    public function createPermissions(array $permissions): void
    {
        foreach ($permissions as $permission) {
            if (!Permission::where(['name' => $permission, 'guard_name' => $this->guard_name])->first()){
                Permission::create([
                    'guard_name' => $this->guard_name,
                    'name' => $permission
                ]);
            }
        }
    }

    public function deletePermission ($roleName) {

    }

}
