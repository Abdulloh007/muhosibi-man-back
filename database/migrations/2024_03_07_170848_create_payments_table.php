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
            $table->string('type_id');
            $table->string('date');
            $table->string('number');
            $table->string('payer_account');
            // $table->integer('beneficiary');
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
