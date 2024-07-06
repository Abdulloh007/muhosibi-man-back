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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->integer('type_id');
            $table->string('date');
            $table->string('number')->nullable();
            $table->integer('payer_account');
            $table->enum('status', ['pending', 'payed']);
            $table->string('payment_sum');
            $table->string('payment_purpose');
            $table->string('comment')->nullable();
            $table->unsignedBigInteger('owner_id'); // is beneficiary
            $table->foreign('owner_id')->references('id')->on('counterparties')->onDelete('cascade');
            $table->integer('organization_id');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
