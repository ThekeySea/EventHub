<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin EventHub',
            'email' => 'admin@eventhub.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        User::create([
            'name' => 'EventHub Organizer',
            'email' => 'organizer@eventhub.test',
            'password' => Hash::make('password'),
            'role' => 'organizer',
            'status' => 'active',
        ]);

        User::create([
            'name' => 'EventHub Organizer Two',
            'email' => 'organizer2@eventhub.test',
            'password' => Hash::make('password'),
            'role' => 'organizer',
            'status' => 'active',
        ]);

        User::create([
            'name' => 'EventHub Member',
            'email' => 'member@eventhub.test',
            'password' => Hash::make('password'),
            'role' => 'member',
            'status' => 'active',
        ]);

        User::create([
            'name' => 'EventHub Member Two',
            'email' => 'member2@eventhub.test',
            'password' => Hash::make('password'),
            'role' => 'member',
            'status' => 'active',
        ]);

        User::create([
            'name' => 'EventHub Member Three',
            'email' => 'member3@eventhub.test',
            'password' => Hash::make('password'),
            'role' => 'member',
            'status' => 'active',
        ]);
    }
}
