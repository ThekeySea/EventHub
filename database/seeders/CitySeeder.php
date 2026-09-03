<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $cities = [
            ['name' => 'Jakarta', 'slug' => 'jakarta', 'province' => 'DKI Jakarta', 'is_active' => true],
            ['name' => 'Bandung', 'slug' => 'bandung', 'province' => 'Jawa Barat', 'is_active' => true],
            ['name' => 'Surabaya', 'slug' => 'surabaya', 'province' => 'Jawa Timur', 'is_active' => true],
            ['name' => 'Yogyakarta', 'slug' => 'yogyakarta', 'province' => 'DI Yogyakarta', 'is_active' => true],
            ['name' => 'Semarang', 'slug' => 'semarang', 'province' => 'Jawa Tengah', 'is_active' => true],
            ['name' => 'Medan', 'slug' => 'medan', 'province' => 'Sumatera Utara', 'is_active' => true],
            ['name' => 'Makassar', 'slug' => 'makassar', 'province' => 'Sulawesi Selatan', 'is_active' => true],
            ['name' => 'Denpasar', 'slug' => 'denpasar', 'province' => 'Bali', 'is_active' => true],
            ['name' => 'Batam', 'slug' => 'batam', 'province' => 'Kepulauan Riau', 'is_active' => true],
            ['name' => 'Malang', 'slug' => 'malang', 'province' => 'Jawa Timur', 'is_active' => true],
            ['name' => 'Virtual / Online', 'slug' => 'virtual-online', 'province' => null, 'is_active' => true],
        ];

        foreach ($cities as $city) {
            City::create($city);
        }
    }
}
