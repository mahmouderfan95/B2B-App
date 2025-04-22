<?php

namespace App\Services\Admin;

use App\Models\User;
use Spatie\Permission\Models\Role;

class UserServices
{
    public function getAllUsers()
    {
        $users = User::get(['id','name','email','roles_name']);
        return view('admin.users.index',compact('users'));
    }

    public function createUser()
    {
        $roles = Role::all();
        return view('admin.users.create',compact('roles'));
    }

    public function deleteUser(User $user)
    {
        //delete user function
        try{
            $user->delete();
            return redirect()->back();
        }catch(\Exception $ex){
            return redirect()->back();
        }
    }
}
