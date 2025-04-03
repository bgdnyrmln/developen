<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\Driver;
use App\Models\User;
use App\Models\Tag;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
        ]);


            $tags = Tag::factory(3)->create();
            Car::factory(10)->hasAttached($tags)->create();
        }

}
