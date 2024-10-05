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
        Schema::create('stuffs', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('father_name');
            $table->date('birthday');
            $table->enum('gender', ['Мужской','Женский']);
            $table->string('citizenship');
            $table->enum('contract_type', ['Трудовой', 'Гражданско-правовой', 'Аренды у физлица', 'С учредителем']);
            $table->text('position');
            $table->date('begin_date');
            $table->string('experience_days');
            $table->string("unique_number");
            $table->text('passport_details')->nullable();
            $table->text('legal_address')->nullable();
            $table->text('physic_address')->nullable();
            $table->string('inn');
            $table->integer('organization_id');
            $table->decimal('salary',10,2)->nullable();
            $table->enum('payment_method', ['Наличными','На карту зарплатного проекта','На личную карту']);
            $table->enum('status', ['Работает','Уволен','В отпуске', 'На декрете']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stuffs');
    }
};
