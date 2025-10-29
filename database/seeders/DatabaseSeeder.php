<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Unity;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $unities = [
            [
                'slug' => 'kilo',
                'name' => 'Kilogramme'
            ],
            [
                'slug' => 'unity',
                'name' => 'Unité'
            ],
            [
                'slug' => 'liter',
                'name' => 'Litre'
            ],
            [
                'slug' => 'palet',
                'name' => 'Palette'
            ],
        ];

        foreach($unities as $unity)
        {
            $model = new Unity();
            $model->slug = $unity['slug'];
            $model->name = $unity['name'];
            $model->save();
        }
    }
}
