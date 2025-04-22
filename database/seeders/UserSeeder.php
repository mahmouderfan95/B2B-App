<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@themesbrand.com',
            'password' => bcrypt('12345678'),
            'avatar' => 'avatar-1.jpg',
            'created_at' => now(),
            'roles_name' => ['super_admin']
        ]);
        $role = Role::find(1);

        // $permissions = Permission::pluck('id','id')->all();

        // $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
    }
}
