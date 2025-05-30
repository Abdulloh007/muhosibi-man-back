<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call(ActivitiesSeeder::class);
        $this->call(DocumentsTypeSeeder::class);
        $this->call(CounterpartyCategorySeeder::class);
        $this->call(TransactionTypeSeeder::class);
        $this->call(TransactionDocTypeSeeder::class);
        $this->call(DocGroupSeeder::class);
        $this->call(CurrencySeeder::class);
    }
}
