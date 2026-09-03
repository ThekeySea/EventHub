<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventFoundationTest extends TestCase
{
    use RefreshDatabase;
    public function test_event_model_has_correct_fillable_attributes(): void
    {
        $event = new Event();
        $expectedFillable = [
            'organizer_id',
            'user_id',
            'category_id',
            'event_type_id',
            'event_format_id',
            'city_id',
            'title',
            'slug',
            'description',
            'banner',
            'event_type',
            'city',
            'location',
            'address',
            'online_url',
            'start_at',
            'end_at',
            'timezone',
            'capacity',
            'payment_method',
            'payment_info',
            'registration_deadline',
            'status',
            'rejection_reason',
        ];

        $this->assertEqualsCanonicalizing($expectedFillable, $event->getFillable());
    }

    public function test_event_model_has_correct_casts(): void
    {
        $event = new Event();
        $casts = $event->getCasts();

        $this->assertArrayHasKey('start_at', $casts);
        $this->assertArrayHasKey('end_at', $casts);
        $this->assertArrayHasKey('registration_deadline', $casts);
        $this->assertArrayHasKey('capacity', $casts);
        $this->assertEquals('datetime', $casts['start_at']);
        $this->assertEquals('datetime', $casts['end_at']);
        $this->assertEquals('datetime', $casts['registration_deadline']);
        $this->assertEquals('integer', $casts['capacity']);
    }

    public function test_event_belongs_to_organizer(): void
    {
        $organizer = User::factory()->create();
        $category = Category::factory()->create();

        $event = Event::factory()->create([
            'organizer_id' => $organizer->id,
            'category_id' => $category->id,
        ]);

        $this->assertEquals($organizer->id, $event->organizer->id);
    }

    public function test_event_belongs_to_category(): void
    {
        $organizer = User::factory()->create();
        $category = Category::factory()->create();

        $event = Event::factory()->create([
            'organizer_id' => $organizer->id,
            'category_id' => $category->id,
        ]);

        $this->assertEquals($category->id, $event->category->id);
    }

    public function test_user_has_many_organized_events(): void
    {
        $organizer = User::factory()->create();
        $category = Category::factory()->create();

        Event::factory()->count(3)->create([
            'organizer_id' => $organizer->id,
            'category_id' => $category->id,
        ]);

        $this->assertCount(3, $organizer->organizedEvents);
    }

    public function test_category_has_many_events(): void
    {
        $organizer = User::factory()->create();
        $category = Category::factory()->create();

        Event::factory()->count(4)->create([
            'organizer_id' => $organizer->id,
            'category_id' => $category->id,
        ]);

        $this->assertCount(4, $category->events);
    }

    public function test_event_slug_is_unique(): void
    {
        $organizer = User::factory()->create();
        $category = Category::factory()->create();

        Event::factory()->create([
            'title' => 'Test Event',
            'slug' => 'test-event',
            'organizer_id' => $organizer->id,
            'category_id' => $category->id,
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);

        Event::factory()->create([
            'title' => 'Another Event',
            'slug' => 'test-event',
            'organizer_id' => $organizer->id,
            'category_id' => $category->id,
        ]);
    }

    public function test_event_status_default_is_draft(): void
    {
        $organizer = User::factory()->create();
        $category = Category::factory()->create();

        $event = Event::factory()->make([
            'organizer_id' => $organizer->id,
            'category_id' => $category->id,
        ]);

        $this->assertEquals('draft', $event->status);
    }

    public function test_event_timezone_default_is_asia_jakarta(): void
    {
        $organizer = User::factory()->create();
        $category = Category::factory()->create();

        $event = Event::factory()->make([
            'organizer_id' => $organizer->id,
            'category_id' => $category->id,
        ]);

        $this->assertEquals('Asia/Jakarta', $event->timezone);
    }

    public function test_event_start_at_and_end_at_are_datetime(): void
    {
        $organizer = User::factory()->create();
        $category = Category::factory()->create();

        $event = Event::factory()->create([
            'organizer_id' => $organizer->id,
            'category_id' => $category->id,
            'start_at' => '2026-09-01 10:00:00',
            'end_at' => '2026-09-01 15:00:00',
        ]);

        $this->assertInstanceOf(\Carbon\Carbon::class, $event->start_at);
        $this->assertInstanceOf(\Carbon\Carbon::class, $event->end_at);
        $this->assertEquals('2026-09-01 10:00:00', $event->start_at->toDateTimeString());
        $this->assertEquals('2026-09-01 15:00:00', $event->end_at->toDateTimeString());
    }

    public function test_event_capacity_is_integer(): void
    {
        $organizer = User::factory()->create();
        $category = Category::factory()->create();

        $event = Event::factory()->create([
            'organizer_id' => $organizer->id,
            'category_id' => $category->id,
            'capacity' => 250,
        ]);

        $this->assertIsInt($event->capacity);
        $this->assertEquals(250, $event->capacity);
    }
}
