<?php

namespace Database\Seeders;
use App\Models\Technology; 
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      $this->call([
        TechnologySeeder::class,
        TypeSeeder::class,
        ProjectSeeder::class,
        UserSeeder::class,
      ]);
    }
}
