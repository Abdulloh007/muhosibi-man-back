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
            $table->text('full_name');
            $table->text('short_name')->nullable();
            $table->text('legal_address')->nullable();
            $table->text('physic_address')->nullable();
            $table->string('site')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('organization_id');
            $table->string('inn')->nullable();
            $table->string('kpp')->nullable();
            $table->text('contacts')->nullable();
            $table->string('for_sign_docs')->nullable();
            $table->string('by_person')->nullable();
            $table->text('passport_details')->nullable();
            $table->text('comment')->nullable();
            $table->enum('payment_method', ['Наличными','На карту зарплатного проекта',' На личную карту'])->nullable();
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
