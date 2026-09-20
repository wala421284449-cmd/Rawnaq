<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\{Permission, Role};

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // 1. إنشاء الأدوار وتوزيعها حسب الـ Guard الصحيح
        $adminRole = Role::firstOrCreate(['name' => 'ولاء مشرف', 'guard_name' => 'admin']);
        Role::firstOrCreate(['name' => 'وسام مشرف', 'guard_name' => 'admin']);
        Role::firstOrCreate(['name' => 'ايمان مشرف', 'guard_name' => 'admin']);

        $ownerRole = Role::firstOrCreate(['name' => 'سماهر مالك', 'guard_name' => 'owner']);
        $customerRole = Role::firstOrCreate(['name' => 'ياسمين زبون', 'guard_name' => 'customer']);


        // ----------------------------------------------------
        // 2. صلاحيات الـ Admin (التحكم الكامل بالإدارة والمشرفين وكل النظام)
        // ----------------------------------------------------
        $adminPermissions = [
            'Create Role',
            'Edit Role',
            'Delete Role',
            'Index Role',
            'Show Role',
            'Create Permission',
            'Edit Permission',
            'Delete Permission',
            'Index Permission',
            'Show Permission',
            'Create City',
            'Edit City',
            'Delete City',
            'Index City',
            'Show City',
            'Create Address',
            'Edit Address',
            'Delete Address',
            'Index Address',
            'Show Address',
            'Create Admin',
            'Edit Admin',
            'Delete Admin',
            'Index Admin',
            'Show Admin',
            'Create Owner',
            'Edit Owner',
            'Delete Owner',
            'Index Owner',
            'Show Owner',
            'Create Customer',
            'Edit Customer',
            'Delete Customer',
            'Index Customer',
            'Show Customer',
            'Index Store',
            'Create Store',
            'Edit Store',
            'Delete Store',
            'Show Store',
            'Index MediaGallery',
            'Create MediaGallery',
            'Edit MediaGallery',
            'Delete MediaGallery',
            'Show MediaGallery',
            'Index ContactMessage',
            'Create ContactMessage',
            'Edit ContactMessage',
            'Delete ContactMessage',
            'Show ContactMessage',
            'Index Category',
            'Create Category',
            'Show Category',
            'Delete Category',
            'Edit Category',
            'Index Service',
            'Create Service',
            'Show Service',
            'Edit Service',
            'Delete Service',
            'Index Product',
            'Create Product',
            'Show Product',
            'Edit Product',
            'Delete Product',
            'Index Offer',
            'Create Offer',
            'Show Offer',
            'Edit Offer',
            'Delete Offer',
            'Index Order',
            'Create Order',
            'Show Order',
            'Edit Order',
            'Delete Order',
            'Index Review',
            'Show Review',
            'Edit Review',
            'Delete Review',
            'Create Review'
        ];

        $createdAdminPermissions = [];
        foreach ($adminPermissions as $permissionName) {
            $createdAdminPermissions[] = Permission::firstOrCreate([
                'name' => $permissionName,
                'guard_name' => 'admin'
            ]);
        }
        // منح جميع الصلاحيات للـ Admin
        $adminRole->syncPermissions($createdAdminPermissions);


        // ----------------------------------------------------
        // 3. صلاحيات الـ Owner (المالك)
        // ----------------------------------------------------
        $ownerPermissions = [
            'Index City',
            'Show City',
            'Index Address',
            'Show Address',
            'Index Store',
            'Create Store',
            'Edit Store',
            'Delete Store',
            'Show Store',
            'Index MediaGallery',
            'Create MediaGallery',
            'Edit MediaGallery',
            'Delete MediaGallery',
            'Show MediaGallery',
            'Index ContactMessage',
            'Edit ContactMessage',
            'Show ContactMessage',
            'Index Category',
            'Show Category',
            'Index Service',
            'Create Service',
            'Show Service',
            'Edit Service',
            'Delete Service',
            'Index Product',
            'Create Product',
            'Show Product',
            'Edit Product',
            'Delete Product',
            'Index Offer',
            'Create Offer',
            'Show Offer',
            'Edit Offer',
            'Delete Offer',
            'Index Order',
            'Create Order',
            'Show Order',
            'Edit Order',
            'Delete Order',
            'Index Review',
            'Show Review',
            'Edit Review',
            'Delete Review'
        ];

        $createdOwnerPermissions = [];
        foreach ($ownerPermissions as $permissionName) {
            $createdOwnerPermissions[] = Permission::firstOrCreate([
                'name' => $permissionName,
                'guard_name' => 'owner'
            ]);
        }
        $ownerRole->syncPermissions($createdOwnerPermissions);


        // ----------------------------------------------------
        // 4. صلاحيات الـ Customer (الزبون)
        // ----------------------------------------------------
        $customerPermissions = [
            'Show Address',
            'Edit Address',
            'Index Address',
        ];

        $createdCustomerPermissions = [];
        foreach ($customerPermissions as $permissionName) {
            $createdCustomerPermissions[] = Permission::firstOrCreate([
                'name' => $permissionName,
                'guard_name' => 'customer'
            ]);
        }
        $customerRole->syncPermissions($createdCustomerPermissions);
    }
}
