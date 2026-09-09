<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            // محافظة شمال غزة
            ['name' => 'بيت لاهيا', 'slug' => 'beit-lahia', 'is_active' => 'active'],
            ['name' => 'بيت حانون', 'slug' => 'beit-hanoun', 'is_active' => 'active'],
            ['name' => 'جباليا', 'slug' => 'jabalia', 'is_active' => 'active'],

            // محافظة غزة
            ['name' => 'مدينة غزة', 'slug' => 'gaza-city', 'is_active' => 'active'],
            ['name' => 'الزهراء', 'slug' => 'al-zahra', 'is_active' => 'active'],
            ['name' => 'المغراقة', 'slug' => 'al-mughraqa', 'is_active' => 'active'],
            ['name' => 'وادي غزة', 'slug' => 'wadi-gaza', 'is_active' => 'active'],

            // محافظة دير البلح (الوسطى)
            ['name' => 'دير البلح', 'slug' => 'deir-al-balah', 'is_active' => 'active'],
            ['name' => 'النصيرات', 'slug' => 'al-nuseirat', 'is_active' => 'active'],
            ['name' => 'البريج', 'slug' => 'al-bureij', 'is_active' => 'active'],
            ['name' => 'المغازي', 'slug' => 'al-maghazi', 'is_active' => 'active'],
            ['name' => 'الزويدة', 'slug' => 'al-zawayda', 'is_active' => 'active'],

            // محافظة خانيونس
            ['name' => 'خانيونس', 'slug' => 'khan-younis', 'is_active' => 'active'],
            ['name' => 'بني سهيلا', 'slug' => 'bani-suheila', 'is_active' => 'active'],
            ['name' => 'عبسان الكبيرة', 'slug' => 'abasan-al-kabira', 'is_active' => 'active'],
            ['name' => 'عبسان الصغيرة', 'slug' => 'abasan-al-saghira', 'is_active' => 'active'],
            ['name' => 'خزاعة', 'slug' => 'khuzaa', 'is_active' => 'active'],
            ['name' => 'القرارة', 'slug' => 'al-qarara', 'is_active' => 'active'],
            ['name' => 'الفخاري', 'slug' => 'al-fukhari', 'is_active' => 'active'],

            // محافظة رفح
            ['name' => 'رفح', 'slug' => 'rafah', 'is_active' => 'active'],
            ['name' => 'شوكة الصوفي', 'slug' => 'shokat-as-sufi', 'is_active' => 'active'],
            ['name' => 'النصر', 'slug' => 'al-nasr', 'is_active' => 'active'],
        ];

        foreach ($cities as $city) {
            City::updateOrCreate(
                ['slug' => $city['slug']],
                [
                    'name' => $city['name'],
                    'is_active' => $city['is_active'],
                ]
            );
        }
    }
}
