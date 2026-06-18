<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UsersTableSeeder;
use Database\Seeders\LiturgicalTimeSeeder;
use Database\Seeders\GospelSeeder;
use Database\Seeders\SolemnitySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersTableSeeder::class,
            LiturgicalTimeSeeder::class,
            GospelSeeder::class,
            SolemnitySeeder::class,
        ]);
    }
}
