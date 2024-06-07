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
            $table->string('patronimic');
            $table->enum('gender', ['male','female',null]);
            $table->string('age');
            $table->date('birth');
            $table->string('email');
            $table->string('phone');
            $table->string('password');
            $table->string('code_phrase');
            $table->enum('status', ['disable','active','banned']);
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
