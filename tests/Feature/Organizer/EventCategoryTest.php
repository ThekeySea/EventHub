<?php

namespace Tests\Feature\Organizer;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventCategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_organizer_create_event_page_shows_only_active_categories(): void
    {
        $organizer = User::factory()->create(['role' => 'organizer']);
        
        $activeCategory1 = Category::factory()->create(['name' => 'Technology', 'is_active' => true]);
        $activeCategory2 = Category::factory()->create(['name' => 'Business', 'is_active' => true]);
        $inactiveCategory = Category::factory()->create(['name' => 'Inactive Theme', 'is_active' => false]);

        $response = $this->actingAs($organizer)->get(route('organizer.events.create'));

        $response->assertStatus(200);
        $response->assertSee('Technology');
        $response->assertSee('Business');
        $response->assertDontSee('Inactive Theme');
    }

    public function test_organizer_create_event_page_shows_message_when_no_active_categories(): void
    {
        $organizer = User::factory()->create(['role' => 'organizer']);
        
        Category::factory()->create(['name' => 'Inactive Theme', 'is_active' => false]);

        $response = $this->actingAs($organizer)->get(route('organizer.events.create'));

        $response->assertStatus(200);
        $response->assertSee('Belum ada tema.');
    }

    public function test_organizer_edit_event_page_shows_only_active_categories(): void
    {
        $organizer = User::factory()->create(['role' => 'organizer']);
        $activeCategory = Category::factory()->create(['name' => 'Technology', 'is_active' => true]);
        $inactiveCategory = Category::factory()->create(['name' => 'Inactive Theme', 'is_active' => false]);
        
        $event = \App\Models\Event::factory()->create([
            'organizer_id' => $organizer->id,
            'user_id' => $organizer->id,
            'category_id' => $activeCategory->id,
        ]);

        $response = $this->actingAs($organizer)->get(route('organizer.events.edit', $event));

        $response->assertStatus(200);
        $response->assertSee('Technology');
        $response->assertDontSee('Inactive Theme');
    }
}
