<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Solemnity;

class SolemnitySeeder extends Seeder
{
    public function run(): void
    {
        $items = [

            ['id' => 1, 'name' => 'Anunciación del Señor'],
            ['id' => 2, 'name' => 'San Esteban: Primer martir de la Iglesia.'],
            ['id' => 3, 'name' => 'Hoy se conmemora la figura de Santa Liduina, símbolo de paciencia y fortaleza en el sufrimiento para muchas personas.'],
            ['id' => 4, 'name' => 'San Ambrosio, obispo y doctor de la Iglesia.'],
            ['id' => 5, 'name' => 'Dedicación de la Catedral: Bogotá, en la Catedral solemnidad; en la Diócesis, fiesta.'],
            ['id' => 6, 'name' => 'Festejo del día: San Aniceto papa.'],
            ['id' => 7, 'name' => 'Día del Buen Pastor. Jornada mundial de Oración por las Vocaciones Sacerdotales.'],
            ['id' => 8, 'name' => 'En este sábado 20 de abril de 2024 la iglesia católica conmemora el santo de Hildegunda, Teótimo, Marcelino, Lutardo, Sulpicio, Domingo de Leonisa.'],
            ['id' => 9, 'name' => 'San Jorge, mártir; San Adalberto, obispo y mártir.'],
            ['id' => 10, 'name' => 'San Fidel de Sigmaringa, presbítero y mártir.'],
            ['id' => 11, 'name' => 'San Marcos, evangelista.'],
            ['id' => 12, 'name' => 'Exaltación de la Santa CRUZ.'],
            ['id' => 13, 'name' => 'Cuerpo y Sangre de Cristo.'],
            ['id' => 15, 'name' => 'SANTO TOMÁS, Apostol'],
            ['id' => 16, 'name' => 'Inmaculada Concepción de la Santísima Virgen María'],
            ['id' => 17, 'name' => 'San José, esposo de la Virgen María'],
            ['id' => 18, 'name' => 'Visitación de la Virgen María'],
            ['id' => 19, 'name' => 'Ascensión del Señor'],
            ['id' => 20, 'name' => 'Pentecostés'],
            ['id' => 21, 'name' => 'Santa Maria Virgen Madre de la Iglesia'],
            ['id' => 22, 'name' => 'Cristo Sumo y Eterno Sacerdote'],
            ['id' => 23, 'name' => 'Santísima Trinidad'],
            ['id' => 24, 'name' => 'San Bonifacio'],
            ['id' => 25, 'name' => 'Sagrado Corazón de Jesús'],
            ['id' => 26, 'name' => 'Inmaculado Corazón de María'],
        ];

        foreach ($items as $item) {
            Solemnity::updateOrCreate(
                ['id' => $item['id']],
                $item
            );
        }
    }
}