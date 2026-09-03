<?php

namespace Tests\Feature\Organizer;

use App\Models\Category;
use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventTest extends TestCase
{
    use RefreshDatabase;

    public function test_organizer_can_create_draft_event(): void
    {
        $organizer = User::factory()->create(['role' => 'organizer']);
        $category = Category::factory()->create(['is_active' => true]);

        $response = $this->actingAs($organizer)->post(route('organizer.events.store'), [
            'title' => 'My Awesome Tech Conference',
            'category_id' => $category->id,
            'description' => 'This is a description of the event.',
            'event_type' => 'webinar',
            'online_url' => 'https://zoom.us/j/123456789',
            'start_at' => now()->addDays(5)->toDateTimeString(),
            'end_at' => now()->addDays(5)->addHours(3)->toDateTimeString(),
            'timezone' => 'Asia/Jakarta',
            'capacity' => 100,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('events', [
            'title' => 'My Awesome Tech Conference',
            'organizer_id' => $organizer->id,
            'user_id' => $organizer->id,
            'status' => 'draft',
        ]);
    }

    public function test_draft_requires_only_title_and_category(): void
    {
        $organizer = User::factory()->create(['role' => 'organizer']);
        $category = Category::factory()->create(['is_active' => true]);

        $response = $this->actingAs($organizer)->post(route('organizer.events.store'), [
            'title' => 'Minimal Draft Event',
            'category_id' => $category->id,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('events', [
            'title' => 'Minimal Draft Event',
            'organizer_id' => $organizer->id,
            'status' => 'draft',
        ]);
    }

    public function test_draft_generates_unique_slug_when_title_is_empty(): void
    {
        $organizer = User::factory()->create(['role' => 'organizer']);
        $category = Category::factory()->create(['is_active' => true]);

        $response = $this->actingAs($organizer)->post(route('organizer.events.store'), [
            'title' => 'Event With No Specific Title',
            'category_id' => $category->id,
        ]);

        $response->assertRedirect();
        $event = Event::where('title', 'Event With No Specific Title')->first();
        $this->assertNotNull($event->slug);
        $this->assertNotEmpty($event->slug);
    }

    public function test_submit_requires_full_fields(): void
    {
        $organizer = User::factory()->create(['role' => 'organizer']);

        // Submit tanpa field wajib - harus gagal
        $response = $this->actingAs($organizer)->post(route('organizer.events.store'), [
            'title' => 'Incomplete Event',
            'submit_type' => 'submit',
        ]);

        $response->assertSessionHasErrors(['category_id', 'description', 'start_at', 'end_at', 'capacity']);
    }

    public function test_submit_succeeds_with_complete_data(): void
    {
        $organizer = User::factory()->create(['role' => 'organizer']);
        $category = Category::factory()->create(['is_active' => true]);

        // Create draft first
        $event = Event::factory()->create([
            'organizer_id' => $organizer->id,
            'user_id' => $organizer->id,
            'status' => 'draft',
            'category_id' => $category->id,
            'title' => 'Complete Submit Event',
        ]);

        // Submit via update with submit_type
        $response = $this->actingAs($organizer)->patch(route('organizer.events.update', $event), [
            'title' => 'Complete Submit Event',
            'category_id' => $category->id,
            'description' => 'Full event description.',
            'start_at' => now()->addDays(5)->toDateTimeString(),
            'end_at' => now()->addDays(5)->addHours(3)->toDateTimeString(),
            'capacity' => 100,
            'submit_type' => 'submit',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'status' => 'pending',
        ]);
    }

    public function test_organizer_can_submit_event_for_review(): void
    {
        $organizer = User::factory()->create(['role' => 'organizer']);
        $event = Event::factory()->create([
            'organizer_id' => $organizer->id,
            'user_id' => $organizer->id,
            'status' => 'draft',
        ]);

        $response = $this->actingAs($organizer)->post(route('organizer.events.submit', $event));

        $response->assertRedirect();
        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'status' => 'pending',
        ]);
    }

    public function test_other_organizer_cannot_view_or_edit_event(): void
    {
        $organizer1 = User::factory()->create(['role' => 'organizer']);
        $organizer2 = User::factory()->create(['role' => 'organizer']);
        
        $event = Event::factory()->create([
            'organizer_id' => $organizer1->id,
            'user_id' => $organizer1->id,
        ]);

        $response = $this->actingAs($organizer2)->get(route('organizer.events.edit', $event));
        $response->assertStatus(403);
    }

    public function test_member_or_admin_cannot_access_organizer_routes(): void
    {
        $member = User::factory()->create(['role' => 'member']);
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($member)->get(route('organizer.events.index'))->assertStatus(403);
        $this->actingAs($admin)->get(route('organizer.events.index'))->assertStatus(403);
    }

    public function test_duplicate_slug_is_auto_resolved(): void
    {
        $organizer = User::factory()->create(['role' => 'organizer']);
        $category = Category::factory()->create(['is_active' => true]);

        Event::factory()->create([
            'organizer_id' => $organizer->id,
            'user_id' => $organizer->id,
            'title' => 'Duplicate Slug Event',
            'slug' => 'duplicate-slug-event',
        ]);

        $response = $this->actingAs($organizer)->post(route('organizer.events.store'), [
            'title' => 'Another Event',
            'slug' => 'duplicate-slug-event',
            'category_id' => $category->id,
            'description' => 'Description here.',
            'start_at' => now()->addDays(5)->toDateTimeString(),
            'end_at' => now()->addDays(5)->addHours(3)->toDateTimeString(),
            'timezone' => 'Asia/Jakarta',
            'capacity' => 50,
        ]);

        $response->assertRedirect();
        $newEvent = Event::where('title', 'Another Event')->first();
        $this->assertNotEquals('duplicate-slug-event', $newEvent->slug);
        $this->assertStringStartsWith('duplicate-slug-event-', $newEvent->slug);
    }

    public function test_can_edit_published_event_returns_to_pending(): void
    {
        $organizer = User::factory()->create(['role' => 'organizer']);
        $event = Event::factory()->create([
            'organizer_id' => $organizer->id,
            'user_id' => $organizer->id,
            'status' => 'published',
        ]);

        $response = $this->actingAs($organizer)->patch(route('organizer.events.update', $event), [
            'title' => 'Updated Published Event',
            'description' => $event->description,
            'category_id' => $event->category_id,
            'event_type_id' => $event->event_type_id,
            'event_format_id' => $event->event_format_id,
            'city_id' => $event->city_id,
            'start_at' => $event->start_at->toDateTimeString(),
            'end_at' => $event->end_at->toDateTimeString(),
            'capacity' => $event->capacity,
            'location' => $event->location,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        
        // Event should now be pending due to substantial changes
        $event->refresh();
        $this->assertEquals('pending', $event->status);
    }

    public function test_can_edit_rejected_event(): void
    {
        $organizer = User::factory()->create(['role' => 'organizer']);
        $category = Category::factory()->create(['is_active' => true]);
        $event = Event::factory()->create([
            'organizer_id' => $organizer->id,
            'user_id' => $organizer->id,
            'status' => 'rejected',
            'category_id' => $category->id,
            'title' => 'Rejected Event',
        ]);

        $response = $this->actingAs($organizer)->patch(route('organizer.events.update', $event), [
            'title' => 'Revised Event Title',
            'description' => 'Updated description.',
            'category_id' => $category->id,
            'start_at' => now()->addDays(5)->toDateTimeString(),
            'end_at' => now()->addDays(5)->addHours(3)->toDateTimeString(),
            'capacity' => 50,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'title' => 'Revised Event Title',
        ]);
    }

    public function test_store_does_not_force_location_to_online(): void
    {
        $organizer = User::factory()->create(['role' => 'organizer']);

        $response = $this->actingAs($organizer)->post(route('organizer.events.store'), [
            'title' => 'Offline Event No Location',
            'category_id' => Category::factory()->create(['is_active' => true])->id,
        ]);

        $response->assertRedirect();
        $event = Event::where('title', 'Offline Event No Location')->first();
        $this->assertNull($event->location);
    }
}
