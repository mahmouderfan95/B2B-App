<?php

namespace App\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index()
    {
        return view('vendor.permissions.index')->with([
            'permissions' => Permission::where('guard_name', 'sub_vendor')->orderBy('guard_name')->get(['name', 'id'])
        ]);
    }
}
