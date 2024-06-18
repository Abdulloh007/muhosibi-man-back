<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActivitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('activities')->insert([
            'title' => "Продажа товаров",
            'description' => "Продажа товаров",
        ]);

        DB::table('activities')->insert([
            'title' => "Оказание услуг",
            'description' => "Оказание услуг",
        ]);

        DB::table('activities')->insert([
            'title' => "Производство",
            'description' => "Производство",
        ]);

        DB::table('activities')->insert([
            'title' => "Строительство",
            'description' => "Строительство",
        ]);

        DB::table('activities')->insert([
            'title' => "Прочее",
            'description' => "Прочее",
        ]);
    }
}
