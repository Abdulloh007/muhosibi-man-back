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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->enum('operation', ['income','payment']);
            $table->integer('type_id');
            $table->integer('doctype_id')->nullable();
            $table->integer('document_id')->nullable();
            $table->enum('resource', ['cash', 'bank', 'ect']);
            $table->string('title');
            $table->string('details');
            $table->date('date');
            $table->float('total');
            $table->float('total_tax');
            $table->unsignedBigInteger('counterparty_id')->nullable();
            $table->foreign('counterparty_id')->references('id')->on('counterparties')->onDelete('cascade');
            $table->unsignedBigInteger('payment_account')->nullable();
            $table->foreign('payment_account')->references('id')->on('payment_accounts')->onDelete('cascade');
            $table->integer('organization_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
