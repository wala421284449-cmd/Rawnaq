<?php

namespace Database\Seeders;

use App\Models\Address;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $addresses = [
            // --- محافظة غزة (city_id: 1) ---
            ['street' => 'شارع الوحدة', 'area' => 'الرمال', 'city_id' => 1],
            ['street' => 'شارع عمر المختار', 'area' => 'الدرج', 'city_id' => 1],
            ['street' => 'شارع الثلاثيني', 'area' => 'تل الهوا', 'city_id' => 1],
            ['street' => 'شارع النصر', 'area' => 'حي النصر', 'city_id' => 1],
            ['street' => 'شارع الجلاء', 'area' => 'الشيخ رضوان', 'city_id' => 1],

            // --- محافظة خانيونس (city_id: 2) ---
            ['street' => 'شارع جلال', 'area' => 'المركز', 'city_id' => 2],
            ['street' => 'شارع البحر', 'area' => 'المخيم', 'city_id' => 2],
            ['street' => 'شارع السطر', 'area' => 'السطر الشرقي والغربي', 'city_id' => 2],
            ['street' => 'شارع خمسة', 'area' => 'عبسان الكبيرة', 'city_id' => 2],
            ['street' => 'شارع الكتيبة', 'area' => 'معن', 'city_id' => 2],

            // --- محافظة رفح (city_id: 3) ---
            ['street' => 'شارع أبو بكر الصديق', 'area' => 'القرارة / تل السلطان', 'city_id' => 3],
            ['street' => 'شارع عسقلان', 'area' => 'المخيم الغربي', 'city_id' => 3],
            ['street' => 'شارع جورج', 'area' => 'الشوكة', 'city_id' => 3],
            ['street' => 'شارع صلاح الدين الرئيسي', 'area' => 'البوكسية', 'city_id' => 3],

            // --- محافظة دير البلح (city_id: 4) ---
            ['street' => 'شارع البخاري', 'area' => 'حكر الجامع', 'city_id' => 4],
            ['street' => 'شارع العشرين', 'area' => 'المخيم الجديد', 'city_id' => 4],
            ['street' => 'شارع السوايرية', 'area' => 'دير البلح البلد', 'city_id' => 4],

            // --- محافظة الشمال (city_id: 5) ---
            ['street' => 'شارع بيت لاهيا العام', 'area' => 'السلاطين', 'city_id' => 5],
            ['street' => 'شارع النزهة', 'area' => 'جباليا النزلة', 'city_id' => 5],
            ['street' => 'شارع الهوجا', 'area' => 'مخيم جباليا', 'city_id' => 5],
            ['street' => 'شارع بيت حانون الرئيسي', 'area' => 'المنشية', 'city_id' => 5],

            // --- المحافظة الوسطى (city_id: 6) ---
            ['street' => 'شارع سوق النصيرات', 'area' => 'المخيم - المعسكر', 'city_id' => 6],
            ['street' => 'شارع العقاد', 'area' => 'البريج', 'city_id' => 6],
            ['street' => 'شارع المدارس', 'area' => 'المغازي', 'city_id' => 6],
            ['street' => 'شارع أبو صبيح', 'area' => 'زوايدة', 'city_id' => 6],
        ];

        foreach ($addresses as $address) {
            Address::firstOrCreate(
                ['street' => $address['street'], 'area' => $address['area']],
                [
                    'city_id'    => $address['city_id'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
