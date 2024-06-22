<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('transaction_types')->insert([
            "title" => "Бизнес",
            "description" => "",
            "is_group" => true
        ]);

        DB::table('transaction_types')->insert([
            "title" => "Налоги и взносы",
            "description" => "",
            "is_group" => true
        ]);

        DB::table('transaction_types')->insert([
            "title" => "Сотрудники",
            "description" => "",
            "is_group" => true
        ]);

        DB::table('transaction_types')->insert([
            "title" => "Банковские операции",
            "description" => "",
            "is_group" => true
        ]);

        DB::table('transaction_types')->insert([
            "title" => "Другие операции",
            "description" => "",
            "is_group" => true
        ]);

        DB::table('transaction_types')->insert([
            "title" => "Оплата товаров и услууг",
            "description" => "",
            "operation" => "income",
            "parent_id" => 1
        ]);

        DB::table('transaction_types')->insert([
            "title" => "Аванс от клиента",
            "description" => "",
            "operation" => "income",
            "parent_id" => 1
        ]);

        DB::table('transaction_types')->insert([
            "title" => "Поступление выручки по эквайрингу",
            "description" => "",
            "operation" => "income",
            "parent_id" => 1
        ]);

        DB::table('transaction_types')->insert([
            "title" => "Возврат средств от поставщика",
            "description" => "",
            "operation" => "income",
            "parent_id" => 1
        ]);

        DB::table('transaction_types')->insert([
            "title" => "Реализация по агентскомуу договору",
            "description" => "",
            "operation" => "income",
            "parent_id" => 1
        ]);

        DB::table('transaction_types')->insert([
            "title" => "Аванс от клиента",
            "description" => "",
            "operation" => "income",
            "parent_id" => 1
        ]);

        DB::table('transaction_types')->insert([
            "title" => "Возврат предоплаты по налогам и взносам",
            "description" => "",
            "operation" => "income",
            "parent_id" => 2
        ]);

        DB::table('transaction_types')->insert([
            "title" => "Возврат предоплаты по налогам и взносам за сотрудника",
            "description" => "",
            "operation" => "income",
            "parent_id" => 2
        ]);

        DB::table('transaction_types')->insert([
            "title" => "Возврат подочётной суммы",
            "description" => "",
            "operation" => "income",
            "parent_id" => 3
        ]);

        DB::table('transaction_types')->insert([
            "title" => "Возврат предоплаты по зарплате",
            "description" => "",
            "operation" => "income",
            "parent_id" => 3
        ]);

        DB::table('transaction_types')->insert([
            "title" => "Пополнение счёта наличными",
            "description" => "",
            "operation" => "income",
            "parent_id" => 4
        ]);

        DB::table('transaction_types')->insert([
            "title" => "Перевод между счетами",
            "description" => "",
            "operation" => "income",
            "parent_id" => 4
        ]);

        DB::table('transaction_types')->insert([
            "title" => "Зачисление денег от продажи валюты",
            "description" => "",
            "operation" => "income",
            "parent_id" => 4
        ]);

        DB::table('transaction_types')->insert([
            "title" => "Зачисление остатка по заявке на покупку валюты",
            "description" => "",
            "operation" => "income",
            "parent_id" => 4
        ]);

        DB::table('transaction_types')->insert([
            "title" => "Получение кридита или займа",
            "description" => "",
            "operation" => "income",
            "parent_id" => 5
        ]);

        DB::table('transaction_types')->insert([
            "title" => "Целевое финансирование и субсидии",
            "description" => "",
            "operation" => "income",
            "parent_id" => 5
        ]);

        DB::table('transaction_types')->insert([
            "title" => "Возврат обеспичительного платежа или залога",
            "description" => "",
            "operation" => "income",
            "parent_id" => 5
        ]);

        DB::table('transaction_types')->insert([
            "title" => "Проценты по депозиту и остатку на р/с",
            "description" => "",
            "operation" => "income",
            "parent_id" => 5
        ]);

        DB::table('transaction_types')->insert([
            "title" => "Возврат депозита",
            "description" => "",
            "operation" => "income",
            "parent_id" => 5
        ]);

        DB::table('transaction_types')->insert([
            "title" => "Прочие доходы",
            "description" => "",
            "operation" => "income",
            "parent_id" => 5
        ]);

        DB::table('transaction_types')->insert([
            "title" => "Не указан",
            "operation" => "income",
            "description" => ""
        ]);

        DB::table('transaction_types')->insert([
            "title" => "Не указан",
            "operation" => "payment",
            "description" => ""
        ]);

        DB::table('transaction_types')->insert([
            "title" => "Оплата товаров и услуг",
            "description" => "",
            "operation" => "payment",
            "parent_id" => 1
        ]);

        DB::table('transaction_types')->insert([
            "title" => "Аванс поставщику",
            "description" => "",
            "operation" => "payment",
            "parent_id" => 1
        ]);

        DB::table('transaction_types')->insert([
            "title" => "Возврат денег клиенту",
            "description" => "",
            "operation" => "payment",
            "parent_id" => 1
        ]);

        DB::table('transaction_types')->insert([
            "title" => "Выплаты по агентственному договору",
            "description" => "",
            "operation" => "payment",
            "parent_id" => 1
        ]);

        DB::table('transaction_types')->insert([
            "title" => "Уплаты налогов и взносов",
            "description" => "",
            "operation" => "payment",
            "parent_id" => 2
        ]);

        DB::table('transaction_types')->insert([
            "title" => "Уплаты страховых взносов за ИП",
            "description" => "",
            "operation" => "payment",
            "parent_id" => 2
        ]);

        DB::table('transaction_types')->insert([
            "title" => "Уплаты страховых взносов за сотруднков",
            "description" => "",
            "operation" => "payment",
            "parent_id" => 2
        ]);

        DB::table('transaction_types')->insert([
            "title" => "Пении, штрафы по налогам и взносам",
            "description" => "",
            "operation" => "payment",
            "parent_id" => 2
        ]);

        DB::table('transaction_types')->insert([
            "title" => "Выплата сотруднику",
            "description" => "",
            "operation" => "payment",
            "parent_id" => 3
        ]);

        DB::table('transaction_types')->insert([
            "title" => "Выплата денег под отчёт",
            "description" => "",
            "operation" => "payment",
            "parent_id" => 3
        ]);

        DB::table('transaction_types')->insert([
            "title" => "Выплаты по зарплатному проекту",
            "description" => "",
            "operation" => "payment",
            "parent_id" => 3
        ]);

        DB::table('transaction_types')->insert([
            "title" => "Снятие наличных со счета",
            "description" => "",
            "operation" => "payment",
            "parent_id" => 4
        ]);

        DB::table('transaction_types')->insert([
            "title" => "Вывод денег на личный счет",
            "description" => "",
            "operation" => "payment",
            "parent_id" => 4
        ]);

        DB::table('transaction_types')->insert([
            "title" => "Перевод между счетами",
            "description" => "",
            "operation" => "payment",
            "parent_id" => 4
        ]);

        DB::table('transaction_types')->insert([
            "title" => "Оплата комиссии банка",
            "description" => "",
            "operation" => "payment",
            "parent_id" => 4
        ]);

        DB::table('transaction_types')->insert([
            "title" => "Покупка валюты с зачислением на валютный счет",
            "description" => "",
            "operation" => "payment",
            "parent_id" => 4
        ]);

        DB::table('transaction_types')->insert([
            "title" => "Выплата процентов по кредиту",
            "description" => "",
            "operation" => "payment",
            "parent_id" => 5
        ]);

        DB::table('transaction_types')->insert([
            "title" => "Возврат кредита или займа",
            "description" => "",
            "operation" => "payment",
            "parent_id" => 5
        ]);

        DB::table('transaction_types')->insert([
            "title" => "Внесение на депозит",
            "description" => "",
            "operation" => "payment",
            "parent_id" => 5
        ]);

        DB::table('transaction_types')->insert([
            "title" => "Обеспечительный платеж или залог",
            "description" => "",
            "operation" => "payment",
            "parent_id" => 5
        ]);
    }
}
