<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker)
    {
        // recupiramo collezione di Type da DB
        $types = Type::all();
        // Creamo un arrtay con solo id di ogni collezione per passare questo dato a randoElement() 
        $ids = $types->pluck('id');

        for ($i = 0; $i < 100; $i++) {
            $new_project = new Project();

            $new_project->title = $faker->sentence(5);
            $new_project->slug = Str::slug($new_project->title, '-');
            $new_project->description = $faker->text(500);
            $new_project->url = $faker->url();
            $new_project->type_id = $faker->optional()->randomElement($ids);
            $new_project->save();
        }
    }
}
