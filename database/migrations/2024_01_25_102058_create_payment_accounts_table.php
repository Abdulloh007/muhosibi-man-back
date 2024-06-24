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
        Schema::create('payment_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('account');
            $table->string('bank_code')->nullable();
            $table->string('bank_name');
            $table->string('bic');
            $table->string('сorrespondent_account')->nullable();
            $table->string('comments')->nullable();
            $table->enum('status', ['active', 'close'])->default('active');      
            $table->unsignedBigInteger('owner_id');
            $table->foreign('owner_id')->references('id')->on('counterparties')->onDelete('cascade');
            $table->float('balance')->default(0);
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_accounts');
    }
};
