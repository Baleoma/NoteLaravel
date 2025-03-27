<?php

namespace Database\Seeders;

use App\Models\Tags;
use App\Models\Notes;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Container\Attributes\Tag;
use Illuminate\Database\Seeder;
use Laravel\Prompts\Note;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        Tags::factory(10)->create();
        Notes::factory(10)->create();
    }
}
