<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CounterpartyCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('countrparty_categories')->insert([
            'title' => 'Клиенты',
            'description' => 'Группа клиентов'
        ]);

        DB::table('countrparty_categories')->insert([
            'title' => 'Поставщики',
            'description' => 'Группа поставщиков'
        ]);
        
        DB::table('countrparty_categories')->insert([
            'title' => 'Прочее',
            'description' => 'Группа прочее'
        ]);
    }
}
