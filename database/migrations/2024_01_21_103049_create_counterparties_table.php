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
        Schema::create('counterparties', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('short_name');
            $table->string('legal_address');
            $table->string('physic_address');
            $table->string('site');
            $table->integer('category_id')->nullable();
            $table->string('inn');
            $table->string('kpp');
            $table->string('contacts');
            $table->string('for_sign_docs');
            $table->string('by_person');
            $table->string('passport_details');
            $table->string('comment');
            $table->enum('payment_method', ['Наличными','На карту зарплатного проекта',' На личную карту']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('counterparties');
    }
};
