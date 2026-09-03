<?php

namespace Database\Seeders;

use App\Models\{Category,Event,City,EventFormat,EventType,User};
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $o1 = User::where('email','organizer@eventhub.test')->firstOrFail();
        $o2 = User::where('email','organizer2@eventhub.test')->firstOrFail();
        $lookup = fn($m,$s) => $m::where('slug',$s)->first();

        $json = file_get_contents(database_path('seeders/event_data.json'));
        $data = json_decode($json, true);

        foreach ($data['events'] as $i => $e) {
            [$title,$cat,$typ,$fmt,$city,$evtype,$pay,$pi,$loc,$url,$sd,$ed,$tz,$cap,$st,$rej] = $e;
            $endTime = ($sd == 33) ? 11 : ($sd == 35 ? 22 : 17);
            $startTime = ($sd == 33) ? 5 : ($sd == 35 ? 15 : 9);
            $slug = strtolower(trim(preg_replace('/[^a-z0-9]+/i', '-', $title), '-'));
            $banner = $data['banners'][$i] ?? null;
            $org = ($i < 5) ? $o1 : $o2;
            Event::create([
                'organizer_id' => $org->id,
                'user_id' => $org->id,
                'category_id' => $lookup(Category::class, $cat)?->id,
                'event_type_id' => $lookup(EventType::class, $typ)?->id,
                'event_format_id' => $lookup(EventFormat::class, $fmt)?->id,
                'city_id' => $lookup(City::class, $city)?->id,
                'title' => $title,
                'slug' => $slug,
                'description' => 'Deskripsi event '.$title,
                'event_type' => $evtype,
                'payment_method' => $pay ?? 'free',
                'payment_info' => $pi,
                'location' => $loc,
                'online_url' => $url,
                'banner' => $banner,
                'start_at' => Carbon::now()->addDays($sd)->setTime($startTime, 0),
                'end_at' => Carbon::now()->addDays($ed)->setTime($endTime, 0),
                'timezone' => $tz,
                'capacity' => $cap,
                'status' => $st,
                'rejection_reason' => $rej,
            ]);
        }
    }
}
