<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Technology;

// Helpers
use Illuminate\Support\Str;
class TechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $technologies = [
            'HTML5',
            'CSS3',
            'SCSS',
            'JavaScript',
            'Vue 3',
            'PHP',
            'Laravel 9',
            'Markdown',
            'Node',
            'Vite',
        ];
        foreach ($technologies as $key => $technology) {
            $slugtechnology = Str::slug($technology);
            Technology::create([
                'name' => $technology,
                'slug' => $slugtechnology,
            ]);
        }
    }
}
