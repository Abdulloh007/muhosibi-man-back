<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocumentsTypeSeeder extends Seeder
{

    
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $metaTags = [
            "{ФИОИП}",
            "{НазваниеКонтр}",
            "{НомерДокумента}",
            "{ФИОДляПодписи}",
            "{ФИОКонтрДляПодписи}",
            "{ДатаДокумента}",
            "{АдресДляДокументов}",
            "{ИННКонтр}",
            "{Комментарий}",
            "{ЮридическийАдрес}",
            "{КППКонтр}",
            "{СуммаДокументаПрописью}",
            "{ИНН}",
            "{ОГРНКонтр}",
            "{СуммаДокументаБезНДС}",
            "{ОКПО}",
            "{АдресКонтр}",
            "{СуммаСкидки}",
            "{ОГРН}",
            "{ТелефонКонтр}",
            "{СуммаДокумента}",
            "{Телефон}",
            "{РасчетныйСчетКонтр}",
            "{СуммаДокументаСНДСБезСкидки}",
            "{ПочтаДляДокументов}",
            "{КоррСчетКонтр}",
            "{НДС}",
            "{АдресСайта}",
            "{НаименованиеБанкаКонтр}",
            "{СуммаНдсПрописью}",
            "{КонтактныеДанные}",
            "{БИКБанкаКонтр}",
            "{ФактурнаяЧасть}",
            "{РасчетныйСчет}",
            "{КонтрВЛице}",
            "{ДокументОснование}",
            "{КоррСчет}",
            "{ЕмэйлКонтр}",
            "{БИК}",
            "{ПаспортКонтр}",
            "{НаименованиеБанка}",
            "{ДолжностьКонтр}",
            "{НаименованиеБанкаИГородБанка}",
            "{ВЛице}"
        ];

        DB::table('documents_types')->insert([
            'title' => 'Договор',
            'description' => 'Договор',
            'metatag' => json_encode($metaTags),
            'type' => 'outgoing',
            'act' => 'sign'
        ]);

        DB::table('documents_types')->insert([
            'title' => 'Счёт',
            'description' => 'Счёт',
            'metatag' => json_encode($metaTags),
            'type' => 'outgoing',
            'act' => 'pay',
            'hasInvoice' => true
        ]);

        DB::table('documents_types')->insert([
            'title' => 'Акт',
            'description' => 'Акт',
            'metatag' => json_encode($metaTags),
            'type' => 'outgoing',
            'act' => 'sign',
            'hasInvoice' => true
        ]);

        DB::table('documents_types')->insert([
            'title' => 'Накладная',
            'description' => 'Накладная',
            'metatag' => json_encode($metaTags),
            'type' => 'outgoing',
            'act' => 'sign',
            'hasInvoice' => true
        ]);

        // DB::table('documents_types')->insert([
        //     'title' => 'УПД',
        //     'description' => 'УПД',
        //     'metatag' => json_encode($metaTags),
        //     'type' => 'outgoing',
        //     'act' => 'sign',
        //     'hasInvoice' => true
        // ]);
        
        DB::table('documents_types')->insert([
            'title' => 'Счёт',
            'description' => 'Счёт',
            'metatag' => json_encode($metaTags),
            'type' => 'income',
            'act' => 'pay',
            'hasInvoice' => true
        ]);

        DB::table('documents_types')->insert([
            'title' => 'Акт',
            'description' => 'Акт',
            'metatag' => json_encode($metaTags),
            'type' => 'income',
            'act' => 'sign',
            'hasInvoice' => true
        ]);

        DB::table('documents_types')->insert([
            'title' => 'Накладная',
            'description' => 'Накладная',
            'metatag' => json_encode($metaTags),
            'type' => 'income',
            'act' => 'sign',
            'hasInvoice' => true
        ]);

        DB::table('documents_types')->insert([
            'title' => 'УПД',
            'description' => 'УПД',
            'metatag' => json_encode($metaTags),
            'type' => 'income',
            'act' => 'sign',
            'hasInvoice' => true
        ]);

        DB::table('documents_types')->insert([
            'title' => 'Счёт-фактура',
            'description' => 'Счёт-фактура',
            'metatag' => json_encode($metaTags),
            'type' => 'outgoing',
            'act' => 'none'
        ]);

        DB::table('documents_types')->insert([
            'title' => 'Акт сверки',
            'description' => 'Акт сверки',
            'metatag' => json_encode($metaTags),
            'type' => 'outgoing',
            'act' => 'none'
        ]);

        DB::table('documents_types')->insert([
            'title' => 'Другой документ',
            'description' => 'Другой документ',
            'metatag' => json_encode($metaTags),
            'type' => 'outgoing',
            'act' => 'attention'
        ]);

    }
}
