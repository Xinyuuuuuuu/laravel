<?php

namespace Database\Seeders;

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
        // ************************ ERABILTZAILEA EZ ALDATU ***************
          User::factory()->create([//puede estar en el UserSeeder tambien
              'name' => 'Test User',
              'email' => 'test@example.com',
              'password' => '12345',
              'points' => 25,
          ]);

          User::factory(10)->create();

          // Ejecutar otros seeders
        $this->call([
            CategorySeeder::class,
            BadgeSeeder::class,
            ChallengeSeeder::class,
        ]);
    }
}
