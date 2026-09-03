<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get(route('admin.users.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_member_receives_forbidden(): void
    {
        $member = User::factory()->create(['role' => 'member']);

        $response = $this->actingAs($member)->get(route('admin.users.index'));
        $response->assertStatus(403);
    }

    public function test_organizer_receives_forbidden(): void
    {
        $organizer = User::factory()->create(['role' => 'organizer']);

        $response = $this->actingAs($organizer)->get(route('admin.users.index'));
        $response->assertStatus(403);
    }

    public function test_admin_can_list_users(): void
    {
        $admin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@test.com',
            'role' => 'admin',
            'status' => 'active',
        ]);

        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'johndoe@test.com',
            'role' => 'member',
            'status' => 'active',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.users.index'));

        $response->assertStatus(200);
        $response->assertSee('Super Admin');
        $response->assertSee('John Doe');
        $response->assertSee('johndoe@test.com');
    }

    public function test_admin_can_search_and_filter_users(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $organizer = User::factory()->create([
            'name' => 'Festival Organizer',
            'email' => 'fest@event.com',
            'role' => 'organizer',
            'status' => 'active',
        ]);

        $member = User::factory()->create([
            'name' => 'Casual Visitor',
            'email' => 'visitor@event.com',
            'role' => 'member',
            'status' => 'inactive',
        ]);

        // Search by name
        $responseSearch = $this->actingAs($admin)->get(route('admin.users.index', ['search' => 'Festival']));
        $responseSearch->assertStatus(200);
        $responseSearch->assertSee('Festival Organizer');
        $responseSearch->assertDontSee('Casual Visitor');

        // Filter by role
        $responseRole = $this->actingAs($admin)->get(route('admin.users.index', ['role' => 'member']));
        $responseRole->assertStatus(200);
        $responseRole->assertSee('Casual Visitor');
        $responseRole->assertDontSee('Festival Organizer');

        // Filter by is_active = 0 (inactive)
        $responseInactive = $this->actingAs($admin)->get(route('admin.users.index', ['is_active' => '0']));
        $responseInactive->assertStatus(200);
        $responseInactive->assertSee('Casual Visitor');
        $responseInactive->assertDontSee('Festival Organizer');
    }

    public function test_admin_can_view_edit_user_page(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $targetUser = User::factory()->create(['role' => 'member']);

        $response = $this->actingAs($admin)->get(route('admin.users.edit', $targetUser));

        $response->assertStatus(200);
        $response->assertSee($targetUser->name);
        $response->assertSee($targetUser->email);
    }

    public function test_admin_can_update_user_role_and_status(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $targetUser = User::factory()->create([
            'name' => 'Old Name',
            'email' => 'old@test.com',
            'role' => 'member',
            'status' => 'active',
        ]);

        $response = $this->actingAs($admin)->patch(route('admin.users.update', $targetUser), [
            'name' => 'Updated Name',
            'email' => 'updated@test.com',
            'role' => 'organizer',
            'is_active' => 0,
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'id' => $targetUser->id,
            'name' => 'Updated Name',
            'email' => 'updated@test.com',
            'role' => 'organizer',
            'status' => 'inactive',
        ]);
    }

    public function test_admin_cannot_deactivate_self(): void
    {
        $admin = User::factory()->create([
            'name' => 'Main Admin',
            'email' => 'mainadmin@test.com',
            'role' => 'admin',
            'status' => 'active',
        ]);

        $response = $this->actingAs($admin)->patch(route('admin.users.update', $admin), [
            'name' => 'Main Admin',
            'email' => 'mainadmin@test.com',
            'role' => 'admin',
            'is_active' => 0,
        ]);

        $response->assertSessionHas('error');

        $admin->refresh();
        $this->assertEquals('active', $admin->status);
        $this->assertTrue($admin->is_active);
    }
}
