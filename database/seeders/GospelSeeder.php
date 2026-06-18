<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gospel;

class GospelSeeder extends Seeder
{
    public function run(): void
    {
        $gospels = [
            [
                'id' => 1,
                'name' => 'Mateo',
                'slug' => 'mateo',
            ],
            [
                'id' => 2,
                'name' => 'Marcos',
                'slug' => 'marcos',
            ],
            [
                'id' => 3,
                'name' => 'Lucas',
                'slug' => 'lucas',
            ],
            [
                'id' => 4,
                'name' => 'Juan',
                'slug' => 'juan',
            ],
        ];

        foreach ($gospels as $gospel) {
            Gospel::updateOrCreate(
                ['id' => $gospel['id']],
                $gospel
            );
        }
    }
}