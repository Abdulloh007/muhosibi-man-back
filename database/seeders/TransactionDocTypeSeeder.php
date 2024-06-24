<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionDocTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('transaction_doc_types')->insert([
            'title' => 'Платежное поручение',
            'description' => '',
            'operation' => 'income',
        ]);

        DB::table('transaction_doc_types')->insert([
            'title' => 'Взнос наличными',
            'description' => '',
            'operation' => 'income',
        ]);

        DB::table('transaction_doc_types')->insert([
            'title' => 'Инкассовое поручение',
            'description' => '',
            'operation' => 'income',
        ]);

        DB::table('transaction_doc_types')->insert([
            'title' => 'Мемориальный ордер',
            'description' => '',
            'operation' => 'income',
        ]);

        DB::table('transaction_doc_types')->insert([
            'title' => 'Банковский ордер',
            'description' => '',
            'operation' => 'income',
        ]);

        DB::table('transaction_doc_types')->insert([
            'title' => 'Платежное поручение',
            'description' => '',
            'operation' => 'payment',
        ]);

        DB::table('transaction_doc_types')->insert([
            'title' => 'Платежное требование',
            'description' => '',
            'operation' => 'payment',
        ]);

        DB::table('transaction_doc_types')->insert([
            'title' => 'Инкассовое поручение',
            'description' => '',
            'operation' => 'payment',
        ]);

        DB::table('transaction_doc_types')->insert([
            'title' => 'Мемориальный ордер',
            'description' => '',
            'operation' => 'payment',
        ]);

        DB::table('transaction_doc_types')->insert([
            'title' => 'Банковский ордер',
            'description' => '',
            'operation' => 'payment',
        ]);

        DB::table('transaction_doc_types')->insert([
            'title' => 'Платежный ордер',
            'description' => '',
            'operation' => 'payment',
        ]);

    }
}
