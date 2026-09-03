<?php

namespace Database\Seeders;

use App\Models\EventType;
use Illuminate\Database\Seeder;

class EventTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'Daring', 'slug' => 'daring', 'description' => 'Acara yang diselenggarakan sepenuhnya secara online.', 'is_active' => true],
            ['name' => 'Luring', 'slug' => 'luring', 'description' => 'Acara yang diselenggarakan di lokasi fisik.', 'is_active' => true],
            ['name' => 'Hybrid', 'slug' => 'hybrid', 'description' => 'Acara yang diselenggarakan secara online sekaligus offline.', 'is_active' => true],
        ];

        foreach ($types as $type) {
            EventType::updateOrCreate(
                ['slug' => $type['slug']],
                $type
            );
        }
    }
}
