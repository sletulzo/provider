<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Unity;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('unities')->truncate();

        $unities = [
            [
                'slug' => 'kilo',
                'name' => 'Kg'
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
