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
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('inn')->nullable(); 
            $table->string('kpp')->nullable();
            $table->enum('tax_system', ['УСН доходы','УСН доходы минус расходы']);
            $table->string('legal_address')->nullable();
            $table->string('physic_address')->nullable();
            $table->unsignedBigInteger('owner_id');
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('type');
            $table->json('contacts')->nullable();
            $table->enum('status', ['active','banned','disable']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};
