<?php

use Illuminate\Database\Seeder;
use App\Model\Tag;
use Faker\Generator as Faker;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $tag_name = [
            'Front-end',
            'Back-end',
            'Fullstack',
            'Divanista',
            'Grafico',
            'Zuzzurellone'
        ];
        foreach ($tag_name as $name) {
          
            $tag = new Tag();
            $tag->label = $name;
            $tag->color = $faker->hexColor();
            $tag->save();
        };
    }
}
