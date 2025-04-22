<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {

    $adminPermission = [
        'statistics',
        'sample-order',
        'public-order',
        'special-order',
        'banners',
        'create-banner',
        'edit-banner',
        'delete-banner',
        'clients',
        'banks',
        'edit-bank',
        'delete-bank',
        'user-permissions',
        'users',
        'add-user',
        'delete-user',
        'roles-permissions',
        'add-role',
        'delete-role',
        'categories',
        'create-category',
        'edit-category',
        'delete-category',
        'products',
        'show-product',
        'create-Product',
        'edit-Product',
        'delete-Product',
        'certificates',
        'add-certificate',
        'edit-certificate',
        'delete-certificate',
        'product-types',
        'add-product-type',
        'edit-product-type',
        'delete-product-type',
        'attributeGroups',
        'add-attributeGroups',
        'edit-attributeGroups',
        'delete-attributeGroups',
        'attributes',
        'add-attributes',
        'edit-attributes',
        'delete-attributes',
        'units',
        'add-units',
        'edit-units',
        'delete-units',
        'packages',
        'add-packages',
        'edit-packages',
        'delete-packages',
        'sizes',
        'add-sizes',
        'edit-sizes',
        'delete-sizes',
        'qualities',
        'add-qualities',
        'edit-qualities',
        'delete-qualities',
        'reviews',
        'vendors',
        'edit-vendor',
        'block-vendor',
        'sub-vendors',
        'show-sub-vendor',
        'create-sub-vendor',
        'edit-sub-vendor',
        'delete-sub-vendor',
        'vendor-wallet',
        'transactions',
        'shipping-methods',
        'add-shipping-method',
        'edit-shipping-method',
        'delete-shipping-method',
        'block-shipping-method',
        'shipping-wallet',
        'countries',
        'add-countries',
        'edit-countries',
        'delete-countries',
        'regions',
        'add-regions',
        'edit-regions',
        'delete-regions',
        'cities',
        'add-cities',
        'edit-cities',
        'delete-cities',
        'currencies',
        'edit-currency',
        'languages',
        'add-languages',
        'edit-languages',
        'settings',
        'aboutUss',
        'edit-aboutUss',
        'contact',
        'privacy-policy',
        'edit-privacy-policy',
        'terms-conditions',
        'edit-terms-conditions',
        'fags',
        'add-fags',
        'edit-fags',
        'delete-fags'
    ];

    foreach ($adminPermission as $permission) {
        Permission::create(['guard_name' => 'web', 'name' => $permission]);
    }
        $adminRole = Role::create(['guard_name' => 'web', 'name' => 'super_admin']);

        $adminRole->givePermissionTo($adminPermission);

         $subVendorPermission = [
             'show-agreements',
             'show-my_wallet',
             'show-orders',
             'show-public-orders',
             'show-special-orders',
             'show-products',
              'create-products',
              'edit-products',
              'delete-products',
             'show-sub_vendors',
             'create-sub_vendors',
             'edit-sub_vendors',
             'delete-sub_vendors',
             'show-role',
             'show-permission',
             'show-quotations',
             'quotations-send-replay',
             'delete-quotations'
         ];

         foreach ($subVendorPermission as $permission) {
             Permission::create(['guard_name' => 'sub_vendor', 'name' => $permission]);
         }

         $subVendorRole = Role::create(['guard_name' => 'sub_vendor', 'name' => 'SubVendor']);

         $subVendorRole->givePermissionTo($subVendorPermission);

         // vendor role and permissions
        $vendorPermission = [
            'show-agreements',
            'show-my_wallet',
            'show-orders',
            'show-public-orders',
            'show-special-orders',
            'show-products',
            'create-products',
            'edit-products',
            'delete-products',
            'show-sub_vendors',
            'create-sub_vendors',
            'edit-sub_vendors',
            'delete-sub_vendors',
            'show-role',
            'show-permission',
            'show-quotations',
            'quotations-send-replay',
            'delete-quotations'
        ];

        foreach ($vendorPermission as $permission) {
            Permission::create(['guard_name' => 'vendor', 'name' => $permission]);
        }

        $vendorRole = Role::create(['guard_name' => 'vendor', 'name' => 'Vendor']);

        $vendorRole->givePermissionTo($vendorPermission);
    }
}
