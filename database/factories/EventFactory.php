<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        return [
            'organizer_id' => User::factory(),
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'title' => $this->faker->sentence(),
            'slug' => $this->faker->unique()->slug(),
            'description' => $this->faker->paragraph(),
            'event_type' => 'offline',
            'city' => $this->faker->city(),
            'location' => $this->faker->address(),
            'online_url' => $this->faker->url(),
            'start_at' => $this->faker->dateTimeBetween('now', '+1 month'),
            'end_at' => $this->faker->dateTimeBetween('+1 month', '+2 months'),
            'timezone' => 'Asia/Jakarta',
            'capacity' => $this->faker->numberBetween(50, 500),
            'status' => 'draft',
            'payment_method' => 'free',
            'payment_info' => null,
        ];
    }
}
