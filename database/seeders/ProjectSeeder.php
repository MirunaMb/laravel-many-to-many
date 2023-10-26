<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

use Faker\Generator as Faker;
class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
       for ($i = 0; $i < 100; $i++) {
        $project = new Project();
        $project->title = $faker->catchPhrase();
        $project->content = $faker->paragraph(3,true);
        $project->slug = Str::slug($project->title);
        $project->save();

        }
    
    }

}
