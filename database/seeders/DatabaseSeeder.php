<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. تشغيل seeders المدن والعناوين والأدوار أولاً
        $this->call([
            CitySeeder::class,
            AddressSeeder::class,
            RoleSeeder::class,
            UserSeeder::class, // استدعاء الـ Seeder الجديد هنا
        ]);

        // ==========================================
        // 2. إنشاء حساب مشرف (Admin)
        // ==========================================
        $admin = User::firstOrCreate(
            ['email' => 'walaa@gmail.com'],
            [
                'name'         => 'ولاء مشرف',
                'phone'        => '0590000000',
                'password'     => Hash::make('12345678'),
                'gender'       => 'female',
                'role'         => 'admin',
                'status'       => 'active',
                'addresses_id' => 1,
            ]
        );
        $adminRole = Role::where('name', 'ولاء مشرف')->where('guard_name', 'admin')->first();
        if ($adminRole && !$admin->hasRole($adminRole)) {
            $admin->assignRole($adminRole);
        }


        // ==========================================
        // 3. إنشاء حساب مالك (Owner)
        // ==========================================
        $owner = User::firstOrCreate(
            ['email' => 'owner@rounaq.com'],
            [
                'name'         => 'سماهر مالك',
                'phone'        => '0591111111',
                'password'     => Hash::make('12345678'),
                'gender'       => 'female',
                'role'         => 'owner',
                'status'       => 'active',
                'addresses_id' => 2,
            ]
        );
        $ownerRole = Role::where('name', 'سماهر مالك')->where('guard_name', 'owner')->first();
        if ($ownerRole && !$owner->hasRole($ownerRole)) {
            $owner->assignRole($ownerRole);
        }


        // ==========================================
        // 4. إنشاء حساب زبون (Customer)
        // ==========================================
        $customer = User::firstOrCreate(
            ['email' => 'customer@rounaq.com'],
            [
                'name'         => 'ياسمين زبون',
                'phone'        => '0592222222',
                'password'     => Hash::make('12345678'),
                'gender'       => 'female',
                'role'         => 'customer',
                'status'       => 'active',
                'addresses_id' => 3,
            ]
        );
        $customerRole = Role::where('name', 'ياسمين زبون')->where('guard_name', 'customer')->first();
        if ($customerRole && !$customer->hasRole($customerRole)) {
            $customer->assignRole($customerRole);
        }
    }
}
