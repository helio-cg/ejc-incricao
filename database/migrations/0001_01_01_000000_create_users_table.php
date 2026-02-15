<?php

use App\Enums\UserStatus;
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
            $table->json('dados_pessoais')->nullable();
            $table->json('informacoes_adicionais')->nullable();
            $table->json('filiacao')->nullable();
            $table->integer('pdf_gerado')->default(0);
            $table->string('circulo')->nullable();
            $table->enum('status', array_column(UserStatus::cases(), 'value'))->default('pending');
            $table->rememberToken();
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
