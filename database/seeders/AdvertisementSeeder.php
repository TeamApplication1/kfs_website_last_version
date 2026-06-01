<?php

namespace Database\Seeders;

use App\Models\Advertisement;
use Illuminate\Database\Seeder;

class AdvertisementSeeder extends Seeder
{
    public function run(): void
    {
        $ads = [
            ['street_name' => 'شارع سعد زغلول', 'lat' => 31.111, 'lng' => 30.940, 'type' => 'لافتة', 'height' => 4.5, 'size' => '3×2 متر', 'description' => 'لوحة إعلانية كبيرة على واجهة مبنى تجاري'],
            ['street_name' => 'شارع الجيش', 'lat' => 31.115, 'lng' => 30.945, 'type' => 'لافتة', 'height' => 6.0, 'size' => '4×3 متر', 'description' => 'لوحة نيون على سطح مبنى'],
            ['street_name' => 'شارع الجمهورية', 'lat' => 31.108, 'lng' => 30.938, 'type' => 'لافتة', 'height' => 3.0, 'size' => '2×1.5 متر', 'description' => 'إعلان تجاري لمحل ملابس'],
            ['street_name' => 'شارع بورسعيد', 'lat' => 31.120, 'lng' => 30.950, 'type' => 'لافتة', 'height' => 5.0, 'size' => '3×2 متر', 'description' => 'لوحة إعلانية عند التقاطع'],
            ['street_name' => 'شارع السويس', 'lat' => 31.105, 'lng' => 30.935, 'type' => 'لافتة', 'height' => 4.0, 'size' => '3×1.5 متر', 'description' => 'إعلان دوائي عند صيدلية'],
            ['street_name' => 'ميدان المحطة', 'lat' => 31.118, 'lng' => 30.948, 'type' => 'لافتة', 'height' => 8.0, 'size' => '6×3 متر', 'description' => 'لوحة ضخمة فوق محطة القطار'],
            ['street_name' => 'شارع أحمد عرابي', 'lat' => 31.113, 'lng' => 30.942, 'type' => 'لافتة', 'height' => 3.5, 'size' => '2×1 متر', 'description' => 'إعلان مطعم'],
            ['street_name' => 'شارع السكة الحديد', 'lat' => 31.116, 'lng' => 30.947, 'type' => 'لافتة', 'height' => 5.5, 'size' => '4×2 متر', 'description' => 'لوحة إعلانية لشركة اتصالات'],
        ];

        foreach ($ads as $ad) {
            Advertisement::create($ad);
        }

        $this->command->info('Seeded ' . count($ads) . ' advertisements');
    }
}
