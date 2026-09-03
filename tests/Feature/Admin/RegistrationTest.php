<?php

namespace Tests\Feature\Admin;

use App\Models\Category;
use App\Models\City;
use App\Models\Event;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get(route('admin.registrations.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_member_receives_forbidden(): void
    {
        $member = User::factory()->create(['role' => 'member']);

        $response = $this->actingAs($member)->get(route('admin.registrations.index'));
        $response->assertStatus(403);
    }

    public function test_organizer_receives_forbidden(): void
    {
        $organizer = User::factory()->create(['role' => 'organizer']);

        $response = $this->actingAs($organizer)->get(route('admin.registrations.index'));
        $response->assertStatus(403);
    }

    public function test_admin_can_view_all_registrations(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $organizer = User::factory()->create(['role' => 'organizer']);
        $member = User::factory()->create([
            'name' => 'Budi Santoso',
            'email' => 'budi@test.com',
            'role' => 'member',
        ]);

        $category = Category::factory()->create(['name' => 'Music']);
        $event = Event::create([
            'organizer_id' => $organizer->id,
            'user_id' => $organizer->id,
            'category_id' => $category->id,
            'title' => 'Jakarta Jazz Festival 2026',
            'slug' => 'jakarta-jazz-festival-2026',
            'status' => 'published',
            'start_at' => now()->addDays(5),
            'end_at' => now()->addDays(6),
        ]);

        $registration = Registration::create([
            'event_id' => $event->id,
            'user_id' => $member->id,
            'registration_code' => 'REG-JAZZ2026',
            'status' => 'registered',
            'registered_at' => now(),
        ]);

        $response = $this->actingAs($admin)->get(route('admin.registrations.index'));

        $response->assertStatus(200);
        $response->assertSee('REG-JAZZ2026');
        $response->assertSee('Budi Santoso');
        $response->assertSee('Jakarta Jazz Festival 2026');
        $response->assertSee('Music');
    }

    public function test_admin_can_filter_registrations_by_search(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $organizer = User::factory()->create(['role' => 'organizer']);
        $user1 = User::factory()->create(['name' => 'Alice Wonderland', 'email' => 'alice@test.com']);
        $user2 = User::factory()->create(['name' => 'Bob Builder', 'email' => 'bob@test.com']);

        $category = Category::factory()->create();
        $event1 = Event::create([
            'organizer_id' => $organizer->id,
            'user_id' => $organizer->id,
            'category_id' => $category->id,
            'title' => 'DevOps Summit',
            'slug' => 'devops-summit',
            'status' => 'published',
            'start_at' => now()->addDays(5),
            'end_at' => now()->addDays(6),
        ]);

        $event2 = Event::create([
            'organizer_id' => $organizer->id,
            'user_id' => $organizer->id,
            'category_id' => $category->id,
            'title' => 'Design Conference',
            'slug' => 'design-conference',
            'status' => 'published',
            'start_at' => now()->addDays(10),
            'end_at' => now()->addDays(11),
        ]);

        Registration::create([
            'event_id' => $event1->id,
            'user_id' => $user1->id,
            'registration_code' => 'REG-ALICE01',
            'status' => 'registered',
            'registered_at' => now(),
        ]);

        Registration::create([
            'event_id' => $event2->id,
            'user_id' => $user2->id,
            'registration_code' => 'REG-BOB02',
            'status' => 'registered',
            'registered_at' => now(),
        ]);

        // Search by registration code
        $responseCode = $this->actingAs($admin)->get(route('admin.registrations.index', ['search' => 'REG-ALICE01']));
        $responseCode->assertStatus(200);
        $responseCode->assertSee('REG-ALICE01');
        $responseCode->assertDontSee('REG-BOB02');

        // Search by attendee name
        $responseName = $this->actingAs($admin)->get(route('admin.registrations.index', ['search' => 'Bob']));
        $responseName->assertStatus(200);
        $responseName->assertSee('REG-BOB02');
        $responseName->assertDontSee('REG-ALICE01');

        // Search by event title
        $responseEvent = $this->actingAs($admin)->get(route('admin.registrations.index', ['search' => 'DevOps']));
        $responseEvent->assertStatus(200);
        $responseEvent->assertSee('REG-ALICE01');
        $responseEvent->assertDontSee('REG-BOB02');
    }

    public function test_admin_can_filter_registrations_by_status_and_event(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $organizer = User::factory()->create(['role' => 'organizer']);
        $member = User::factory()->create();

        $category = Category::factory()->create();
        $event1 = Event::create([
            'organizer_id' => $organizer->id,
            'user_id' => $organizer->id,
            'category_id' => $category->id,
            'title' => 'Event One',
            'slug' => 'event-one',
            'status' => 'published',
            'start_at' => now()->addDays(5),
            'end_at' => now()->addDays(6),
        ]);

        $event2 = Event::create([
            'organizer_id' => $organizer->id,
            'user_id' => $organizer->id,
            'category_id' => $category->id,
            'title' => 'Event Two',
            'slug' => 'event-two',
            'status' => 'published',
            'start_at' => now()->addDays(10),
            'end_at' => now()->addDays(11),
        ]);

        $reg1 = Registration::create([
            'event_id' => $event1->id,
            'user_id' => $member->id,
            'registration_code' => 'REG-ONE-ACTIVE',
            'status' => 'registered',
            'registered_at' => now(),
        ]);

        $reg2 = Registration::create([
            'event_id' => $event2->id,
            'user_id' => $member->id,
            'registration_code' => 'REG-TWO-CANCELLED',
            'status' => 'cancelled',
            'registered_at' => now(),
        ]);

        // Filter by status = cancelled
        $responseStatus = $this->actingAs($admin)->get(route('admin.registrations.index', ['status' => 'cancelled']));
        $responseStatus->assertStatus(200);
        $responseStatus->assertSee('REG-TWO-CANCELLED');
        $responseStatus->assertDontSee('REG-ONE-ACTIVE');

        // Filter by event_id = $event1->id
        $responseEvent = $this->actingAs($admin)->get(route('admin.registrations.index', ['event_id' => $event1->id]));
        $responseEvent->assertStatus(200);
        $responseEvent->assertSee('REG-ONE-ACTIVE');
        $responseEvent->assertDontSee('REG-TWO-CANCELLED');
    }
}
