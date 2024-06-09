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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('name');
            $table->string('surname');
            $table->string('patronimic')->nullable();
            $table->enum('gender', ['male','female', 'other'])->nullable();
            $table->string('age')->nullable();
            $table->date('birth')->nullable();
            $table->string('email');
            $table->string('phone');
            $table->string('password');
            $table->string('code_phrase')->nullable();
            $table->enum('status', ['disable','active','banned'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
