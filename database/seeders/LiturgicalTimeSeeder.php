<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LiturgicalTime;

class LiturgicalTimeSeeder extends Seeder
{
    public function run(): void
    {
        $times = [
            [
                'id' => 1,
                'name' => 'Adviento',
                'slug' => 'adviento',
                'color' => 'purple',
            ],
            [
                'id' => 2,
                'name' => 'Navidad',
                'slug' => 'navidad',
                'color' => 'white',
            ],
            [
                'id' => 3,
                'name' => 'Cuaresma',
                'slug' => 'cuaresma',
                'color' => 'purple',
            ],
            [
                'id' => 4,
                'name' => 'Pascua',
                'slug' => 'pascua',
                'color' => 'white',
            ],
            [
                'id' => 5,
                'name' => 'Tiempo Ordinario',
                'slug' => 'tiempo-ordinario',
                'color' => 'green',
            ],
        ];

        foreach ($times as $time) {
            LiturgicalTime::updateOrCreate(
                ['id' => $time['id']],
                $time
            );
        }
    }
}