<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Badge;

class BadgeSeeder extends Seeder
{
    public function run()
    {
    
        $badges = [
            [
                'name' => '2 erronka osatu',
                'description' => '2 erronka osatu dituzu. Horrela jarraitu!',
                'image' => 'badge2.png',
            ],
            [
                'name' => '5 erronka osatu',
                'description' => '5 erronka osatu dituzu. Aditua zara!',
                'image' => 'badge5.png',
            ],
            [
                'name' => '10 erronka osatu',
                'description' => '10 erronka osatu dituzu. Bikain!',
                'image' => 'badge10.png',
            ],
        ];
        

        // Insertar las insignias en la base de datos
        foreach ($badges as $badge) {
            Badge::create($badge);
        }
    }
}