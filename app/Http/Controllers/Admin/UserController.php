<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\Store;
use App\Models\User;
use App\Services\Admin\UserServices;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    private $userServices;
    public function __construct(UserServices $userServices)
    {
        $this->userServices = $userServices;
    }
    public function index()
    {
        return $this->userServices->getAllUsers();
    }

    public function create()
    {
        return $this->userServices->createUser();
    }

    public function store(User $user,Store $request)
    {
        try{
            $userCreate = $user->create($request->validated());
            $userCreate->assignRole($request->input('roles_name'));
            return redirect(route('dashboard.users.index'));
        }catch(\Exception $ex){
            return redirect()->back();
        }
    }
    public function destroy(User $user)
    {
        return $this->userServices->deleteUser($user);
    }
}
