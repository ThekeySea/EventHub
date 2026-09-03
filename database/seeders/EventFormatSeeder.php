<?php

namespace Database\Seeders;

use App\Models\EventFormat;
use Illuminate\Database\Seeder;

class EventFormatSeeder extends Seeder
{
    public function run(): void
    {
        $formats = [
            ['name' => 'Seminar', 'slug' => 'seminar', 'description' => 'Sesi presentasi dan diskusi.', 'is_active' => true],
            ['name' => 'Webinar', 'slug' => 'webinar', 'description' => 'Seminar yang diselenggarakan secara online.', 'is_active' => true],
            ['name' => 'Workshop', 'slug' => 'workshop', 'description' => 'Pelatihan praktis dengan hands-on.', 'is_active' => true],
            ['name' => 'Konser', 'slug' => 'konser', 'description' => 'Pertunjukan musik live.', 'is_active' => true],
            ['name' => 'Festival', 'slug' => 'festival', 'description' => 'Perayaan budaya atau seni.', 'is_active' => true],
            ['name' => 'Pameran', 'slug' => 'pameran', 'description' => 'Pameran karya seni atau produk.', 'is_active' => true],
            ['name' => 'Kompetisi', 'slug' => 'kompetisi', 'description' => 'Lomba atau kompetisi.', 'is_active' => true],
            ['name' => 'Gathering Komunitas', 'slug' => 'community-gathering', 'description' => 'Pertemuan komunitas.', 'is_active' => true],
            ['name' => 'Lainnya', 'slug' => 'lainnya', 'description' => 'Jenis acara lainnya.', 'is_active' => true],
        ];

        foreach ($formats as $format) {
            EventFormat::create($format);
        }
    }
}
