<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        //  $table->string('name');
        //  $table->string('sh_name');
        //  $table->string('code');
        //  $table->string('well');
        DB::table('currency')->insert([
            "name" => "Российский рубль",
            "sh_name" => "RUB",
            "code" => "810",
            "well" => "0.1087",
        ]);
        DB::table('currency')->insert([
            "name" => "Доллар США",
            "sh_name" => "USD",
            "code" => "840",
            "well" => "10.6504",
        ]);
        DB::table('currency')->insert([
            "name" => "ЕВРО",
            "sh_name" => "EUR",
            "code" => "978",
            "well" => "11.6079",
        ]);
    }
}
