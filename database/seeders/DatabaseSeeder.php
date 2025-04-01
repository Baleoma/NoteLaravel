<?php

namespace Database\Seeders;

use App\Models\NoteTag;
use App\Models\Tag;
use App\Models\Note;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        Tag::factory(10)->create();
        Note::factory(10)->create();
        notetag::factory(10)->create();
    }
}
