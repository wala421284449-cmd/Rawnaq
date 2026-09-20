<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Owner;
use App\Models\Customer;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. إنشاء المشرف (ولاء) - لا يحتاج جدول منفصل للـ actor
        $walaAdmin = User::firstOrCreate(
            ['email' => 'wala@admin.com'],
            [
                'name' => 'ولاء مشرف',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
            ]
        );
        $walaAdmin->assignRole(
            \Spatie\Permission\Models\Role::where('name', 'ولاء مشرف')->where('guard_name', 'admin')->first()
        );


        // 2. إنشاء المالك (سماهر) - (إنشاء سجل Owner أولاً ثم ربطه بجدول users)
        $owner = Owner::firstOrCreate(
            ['id_number' => '987654321'], // للبحث من خلاله لعدم التكرار
            [
                'whats_up_number' => '0591111111',
            ]
        );

        $smaherUser = User::firstOrCreate(
            ['email' => 'smaher@owner.com'],
            [
                'name' => 'سماهر مالك',
                'password' => Hash::make('12345678'),
                'role' => 'owner',
                'actor_type' => Owner::class, // ربط الـ Morph بالـ Owner
                'actor_id' => $owner->id,     // ربط الـ ID
            ]
        );
        $smaherUser->assignRole(
            \Spatie\Permission\Models\Role::where('name', 'سماهر مالك')->where('guard_name', 'owner')->first()
        );


        // 3. إنشاء الزبون (ياسمين) - (إنشاء سجل Customer أولاً ثم ربطه بجدول users)
        $customer = Customer::firstOrCreate(
            ['id_number' => '456789123'],
            [
                'whats_up_number' => '0592222222',
            ]
        );

        $yasminUser = User::firstOrCreate(
            ['email' => 'yasmin@customer.com'],
            [
                'name' => 'ياسمين زبون',
                'password' => Hash::make('12345678'),
                'role' => 'customer',
                'actor_type' => Customer::class, // ربط الـ Morph بالـ Customer
                'actor_id' => $customer->id,     // ربط الـ ID
            ]
        );
        $yasminUser->assignRole(
            \Spatie\Permission\Models\Role::where('name', 'ياسمين زبون')->where('guard_name', 'customer')->first()
        );
    }
}
