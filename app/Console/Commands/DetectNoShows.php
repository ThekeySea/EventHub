<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Models\Registration;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DetectNoShows extends Command
{
    protected $signature = 'events:detect-no-shows';
    protected $description = 'Auto-detect no-shows for events that have ended';

    public function handle()
    {
        // Find events that ended more than 1 hour ago
        $endedEvents = Event::where('status', 'published')
            ->where('end_at', '<', Carbon::now()->subHour())
            ->get();

        $count = 0;

        foreach ($endedEvents as $event) {
            // Find registrations that are still 'registered' (not attended, not cancelled, not no_show)
            $noShows = Registration::where('event_id', $event->id)
                ->where('status', Registration::STATUS_REGISTERED)
                ->get();

            foreach ($noShows as $registration) {
                $registration->markNoShow();
                $count++;
            }
        }

        $this->info("Detected {$count} no-shows across {$endedEvents->count()} ended events.");
        return 0;
    }
}
