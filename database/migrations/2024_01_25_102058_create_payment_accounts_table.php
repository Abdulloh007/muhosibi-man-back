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
            $table->string('number');
            $table->string('BIC');
            $table->string('сorrespondent_account');
            $table->string('comments');
            $table->string('status');      
            $table->unsignedBigInteger('owner_id');
            $table->foreign('owner_id')->references('id')->on('counterparties')->onDelete('cascade');
            $table->float('balance');      
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
