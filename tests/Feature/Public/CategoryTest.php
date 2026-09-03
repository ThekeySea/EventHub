<?php

namespace Tests\Feature\Public;

use App\Models\Category;
use App\Models\City;
use App\Models\Event;
use App\Models\EventFormat;
use App\Models\EventType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_categories_index_returns_200_and_lists_active_categories(): void
    {
        $activeCategory1 = Category::create([
            'name' => 'Music',
            'slug' => 'music',
            'description' => 'Music events and concerts',
            'is_active' => true,
        ]);

        $activeCategory2 = Category::create([
            'name' => 'Technology',
            'slug' => 'technology',
            'description' => 'Tech conferences and meetups',
            'is_active' => true,
        ]);

        $inactiveCategory = Category::create([
            'name' => 'Secret Category',
            'slug' => 'secret-category',
            'description' => 'Hidden theme',
            'is_active' => false,
        ]);

        // Create published future event for music
        $organizer = User::factory()->create(['role' => 'organizer']);
        Event::create([
            'organizer_id' => $organizer->id,
            'user_id' => $organizer->id,
            'category_id' => $activeCategory1->id,
            'title' => 'Rock Festival 2026',
            'slug' => 'rock-festival-2026',
            'description' => 'Awesome live rock show',
            'start_at' => now()->addDays(5),
            'end_at' => now()->addDays(6),
            'status' => 'published',
        ]);

        $response = $this->get(route('categories.index'));

        $response->assertStatus(200);
        $response->assertSee('Music');
        $response->assertSee('Technology');
        $response->assertDontSee('Secret Category');
        $response->assertSee('1 Event');
    }

    public function test_categories_show_returns_200_and_displays_category_events(): void
    {
        $category = Category::create([
            'name' => 'Education',
            'slug' => 'education',
            'description' => 'Seminars and workshops',
            'is_active' => true,
        ]);

        $otherCategory = Category::create([
            'name' => 'Sport',
            'slug' => 'sport',
            'description' => 'Sport events',
            'is_active' => true,
        ]);

        $organizer = User::factory()->create(['role' => 'organizer']);

        // Published future event in category
        $event1 = Event::create([
            'organizer_id' => $organizer->id,
            'user_id' => $organizer->id,
            'category_id' => $category->id,
            'title' => 'Laravel Masterclass',
            'slug' => 'laravel-masterclass',
            'description' => 'Learn Laravel in depth',
            'start_at' => now()->addDays(3),
            'end_at' => now()->addDays(4),
            'status' => 'published',
        ]);

        // Draft event in category (should NOT be displayed)
        $draftEvent = Event::create([
            'organizer_id' => $organizer->id,
            'user_id' => $organizer->id,
            'category_id' => $category->id,
            'title' => 'Draft Education Event',
            'slug' => 'draft-education-event',
            'description' => 'Unpublished event',
            'start_at' => now()->addDays(3),
            'end_at' => now()->addDays(4),
            'status' => 'draft',
        ]);

        // Published event in OTHER category (should NOT be displayed)
        $otherEvent = Event::create([
            'organizer_id' => $organizer->id,
            'user_id' => $organizer->id,
            'category_id' => $otherCategory->id,
            'title' => 'Football Championship',
            'slug' => 'football-championship',
            'description' => 'Sport event',
            'start_at' => now()->addDays(3),
            'end_at' => now()->addDays(4),
            'status' => 'published',
        ]);

        $response = $this->get(route('categories.show', $category->slug));

        $response->assertStatus(200);
        $response->assertSee('Laravel Masterclass');
        $response->assertDontSee('Draft Education Event');
        $response->assertDontSee('Football Championship');
    }

    public function test_categories_show_filters_events(): void
    {
        $category = Category::create([
            'name' => 'Technology',
            'slug' => 'technology',
            'is_active' => true,
        ]);

        $typeDaring = EventType::create(['name' => 'Daring', 'slug' => 'daring', 'is_active' => true]);
        $typeLuring = EventType::create(['name' => 'Luring', 'slug' => 'luring', 'is_active' => true]);

        $cityJakarta = City::create(['name' => 'Jakarta', 'slug' => 'jakarta', 'is_active' => true]);
        $cityBandung = City::create(['name' => 'Bandung', 'slug' => 'bandung', 'is_active' => true]);

        $organizer = User::factory()->create(['role' => 'organizer']);

        $event1 = Event::create([
            'organizer_id' => $organizer->id,
            'user_id' => $organizer->id,
            'category_id' => $category->id,
            'event_type_id' => $typeDaring->id,
            'city_id' => $cityJakarta->id,
            'title' => 'AI Revolution Webinar',
            'slug' => 'ai-revolution-webinar',
            'description' => 'Artificial intelligence deep dive',
            'start_at' => now()->addDays(2),
            'end_at' => now()->addDays(3),
            'status' => 'published',
        ]);

        $event2 = Event::create([
            'organizer_id' => $organizer->id,
            'user_id' => $organizer->id,
            'category_id' => $category->id,
            'event_type_id' => $typeLuring->id,
            'city_id' => $cityBandung->id,
            'title' => 'Cloud Computing Summit',
            'slug' => 'cloud-computing-summit',
            'description' => 'In person summit',
            'start_at' => now()->addDays(10),
            'end_at' => now()->addDays(11),
            'status' => 'published',
        ]);

        // Filter by keyword
        $responseQuery = $this->get(route('categories.show', ['slug' => $category->slug, 'q' => 'AI Revolution']));
        $responseQuery->assertStatus(200);
        $responseQuery->assertSee('AI Revolution Webinar');
        $responseQuery->assertDontSee('Cloud Computing Summit');

        // Filter by type
        $responseType = $this->get(route('categories.show', ['slug' => $category->slug, 'type' => 'daring']));
        $responseType->assertStatus(200);
        $responseType->assertSee('AI Revolution Webinar');
        $responseType->assertDontSee('Cloud Computing Summit');

        // Filter by city
        $responseCity = $this->get(route('categories.show', ['slug' => $category->slug, 'city' => 'bandung']));
        $responseCity->assertStatus(200);
        $responseCity->assertSee('Cloud Computing Summit');
        $responseCity->assertDontSee('AI Revolution Webinar');
    }

    public function test_categories_show_returns_404_for_nonexistent_category(): void
    {
        $response = $this->get(route('categories.show', 'non-existent-category'));
        $response->assertStatus(404);
    }

    public function test_categories_show_returns_404_for_inactive_category(): void
    {
        $category = Category::create([
            'name' => 'Inactive Category',
            'slug' => 'inactive-category',
            'is_active' => false,
        ]);

        $response = $this->get(route('categories.show', $category->slug));
        $response->assertStatus(404);
    }
}
