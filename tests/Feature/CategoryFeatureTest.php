<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login()
    {
        $response = $this->get(route('admin.categories.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_member_receives_forbidden()
    {
        $member = User::factory()->create(['role' => 'member']);

        $response = $this->actingAs($member)->get(route('admin.categories.index'));
        $response->assertStatus(403);
    }

    public function test_admin_can_create_category()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post(route('admin.categories.store'), [
            'name' => 'Music & Concerts',
            'description' => 'Live music events',
            'is_active' => 1,
        ]);

        $response->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseHas('categories', [
            'name' => 'Music & Concerts',
            'slug' => 'music-concerts',
        ]);
    }

    public function test_duplicate_slug_is_rejected()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        Category::create([
            'name' => 'Technology',
            'slug' => 'technology',
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->post(route('admin.categories.store'), [
            'name' => 'Technology',
            'slug' => 'technology',
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_admin_can_update_category()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $category = Category::create([
            'name' => 'Sports',
            'slug' => 'sports',
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->patch(route('admin.categories.update', $category), [
            'name' => 'Sports & Fitness',
            'slug' => 'sports-fitness',
            'is_active' => 1,
        ]);

        $response->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Sports & Fitness',
            'slug' => 'sports-fitness',
        ]);
    }

    public function test_admin_can_toggle_category_status()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $category = Category::create([
            'name' => 'Business',
            'slug' => 'business',
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->patch(route('admin.categories.toggle-status', $category));

        $response->assertRedirect();
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'is_active' => false,
        ]);
    }
}