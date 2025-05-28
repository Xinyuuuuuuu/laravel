<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Challenge;

class ChallengeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $challenges = [
            [
                'title' => 'Egun batean 100 flexio egitea',
                'description' => 'Osatu 100 flexio egun bakarrean.',
                'points' => 50,
                'start_date' => now(),
                'end_date' => now()->addWeek(),
                'category' => 'Kirola',
            ],
            [
                'title' => 'Astebetean liburu bat irakurtzea',
                'description' => 'Amaitu liburu bat irakurtzen 7 egunetan.',
                'points' => 30,
                'start_date' => now(),
                'end_date' => now()->addWeek(),
                'category' => 'Irakurketa',
            ],
            [
                'title' => 'Egunean 10 minutuz meditatu astebetez',
                'description' => 'Meditatu 10 minutuz egunero, 7 egunez jarraian.',
                'points' => 40,
                'start_date' => now(),
                'end_date' => now()->addWeek(),
                'category' => 'Osasuna',
            ],
            [
                'title' => 'Idatzi egunkari bat 30 egunez',
                'description' => 'Idatzi egunero egunkari pertsonal batean hilabete batez.',
                'points' => 60,
                'start_date' => now(),
                'end_date' => now()->addMonth(),
                'category' => 'Kultura',
            ],
        ];


        foreach ($challenges as $challengeData) {

            // Bilatu kategoria DBan izenaren arabera
            $category = Category::where('name', 'Deporte')->firstOrFail();


            $challenge = Challenge::create([
                'title' => $challengeData['title'],
                'description' => $challengeData['description'],
                'points' => $challengeData['points'],
                'start_date' => $challengeData['start_date'],
                'end_date' => $challengeData['end_date'],
                'category_id' => $category->id,
            ]);

        }

    }
}
