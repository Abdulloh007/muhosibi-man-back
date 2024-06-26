<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('doc_groups', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('comment');
            $table->enum('status', ['В работе', 'Ждет оплаты', 'Нет счёта', 'Нет акта/накладной/УПД', 'Подписание документов', 'Подписан', 'Не подписан', 'Завершён', 'Отменён']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doc_groups');
    }
};
