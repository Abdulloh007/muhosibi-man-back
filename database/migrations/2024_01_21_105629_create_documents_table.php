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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('template');
            $table->unsignedBigInteger('doc_type');
            $table->foreign('doc_type')->references('id')->on('documents_types')->onDelete('cascade');
            $table->text('metatag');
            $table->text('with_sign_seal');
            $table->text('public');
            $table->text('sum');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
