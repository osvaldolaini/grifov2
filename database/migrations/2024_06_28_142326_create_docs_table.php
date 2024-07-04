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
        Schema::create('docs', function (Blueprint $table) {
            $table->id();
            $table->boolean('active')->nullable();
            $table->string('tipoNome')->nullable();
            $table->string('categoria', 100)->nullable();
            $table->foreignId('docs_types_id')->constrained();
            $table->date('data')->nullable();
            $table->string('status', 100)->nullable();
            $table->string('anexos', 255)->nullable();
            $table->string('documento', 255)->nullable();

            $table->string('origem', 30)->nullable();
            $table->string('destino', 30)->nullable();
            $table->string('numero', 30)->nullable();
            $table->string('numeroExpedicao', 30)->nullable();
            $table->string('referencia', 30)->nullable();
            $table->tinyText('assunto')->nullable();
            $table->mediumText('resenha')->nullable();

            $table->largeText('descricao')->nullable();
            $table->mediumText('palavraChave')->nullable();

            $table->timestamps();
            $table->string('updated_by', 50)->nullable();
            $table->string('created_by', 50)->nullable();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('docs');
    }
};
