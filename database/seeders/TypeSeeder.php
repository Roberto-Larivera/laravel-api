<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// Helpers
use Illuminate\Support\Str;
// Models
use App\Models\Type;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            'Esercitazione',
            'Tester',
            'Statico',
            'CMS',
            'Blog',
            'Aziendale',
            'Istituzionale',
            'E-commerce Artigianale',
            'E-commerce Commerciale',
            'Portale Web',
            'Wiki',
            'Social Network',
            'Forum Discussione',
            'Applicazione Cloud'
        ];
        foreach ($types as $key => $type) {
            $slugType = Str::slug($type);
            Type::create([
                'name' => $type,
                'slug' => $slugType,
            ]);
        }
    }
}
