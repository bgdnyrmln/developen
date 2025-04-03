<?php

namespace Database\Seeders;

use App\Models\Car;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tag;

class Carseeder extends Seeder
{
    public function run(): void
    {
        $tags = Tag::factory(3)->create();
        Car::factory(10)->hasAttached($tags)->create();
    }
}
