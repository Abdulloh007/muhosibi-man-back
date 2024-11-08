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
        Schema::create('transaction_types', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description')->nullable();
            $table->integer('parent_id')->nullable();
            $table->enum('operation', ['income', 'payment'])->nullable();
            $table->boolean('is_group')->default(false);
            $table->string('dual_code')->nullable();
            $table->string('penta_code')->nullable();
            $table->enum('type', ['active', 'passive'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_types');
    }
};
