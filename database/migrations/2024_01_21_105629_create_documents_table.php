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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('template');
            $table->unsignedBigInteger('doc_type');
            $table->foreign('doc_type')->references('id')->on('documents_types')->onDelete('cascade');
            $table->boolean('with_sign_seal');
            $table->text('public');
            $table->text('sum');
            $table->boolean('isGroup')->default(false);
            $table->integer('parent_id')->nullable();
            $table->enum('status', ['В работе', 'Ждет оплаты', 'Нет счёта', 'Нет акта/накладной/УПД', 'Подписание документов', 'Подписан', 'Не подписан', 'Завершён', 'Отменён']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
