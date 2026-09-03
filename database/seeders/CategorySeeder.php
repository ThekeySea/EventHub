<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Musik', 'slug' => 'musik', 'description' => 'Konser, festival musik, dan pertunjukan audio.', 'is_active' => true],
            ['name' => 'Pendidikan', 'slug' => 'pendidikan', 'description' => 'Seminar, workshop, dan pelatihan.', 'is_active' => true],
            ['name' => 'Teknologi', 'slug' => 'teknologi', 'description' => 'Konferensi tech, hackathon, dan inovasi digital.', 'is_active' => true],
            ['name' => 'Olahraga', 'slug' => 'olahraga', 'description' => 'Turnamen, kompetisi olahraga, dan kegiatan fisik.', 'is_active' => true],
            ['name' => 'Bisnis', 'slug' => 'bisnis', 'description' => 'Networking, startup, dan pengembangan usaha.', 'is_active' => true],
            ['name' => 'Seni', 'slug' => 'seni', 'description' => 'Pameran, pertunjukan seni, dan budaya.', 'is_active' => true],
            ['name' => 'Komunitas', 'slug' => 'komunitas', 'description' => 'Gathering, kopdar, dan kegiatan komunitas.', 'is_active' => true],
            ['name' => 'Kompetisi', 'slug' => 'kompetisi', 'description' => 'Lomba, kontes, dan kompetisi berbagai bidang.', 'is_active' => true],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
