<?php

namespace Database\Seeders;

use App\Practice;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */

    public function run(): void
    {
        $this->call([
            GenreSeeder::class,
            MovieSeeder::class,
            SheetSeeder::class,
            ScheduleSeeder::class,
        ]);
    }
}