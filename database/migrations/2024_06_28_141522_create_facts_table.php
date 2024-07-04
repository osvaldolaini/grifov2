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
        Schema::create('facts', function (Blueprint $table) {
            $table->id();
            $table->boolean('active')->nullable();
            $table->integer('numero')->nullable();
            $table->string('categoria', 100)->nullable();
            $table->foreignId('facts_types_id')->constrained();
            $table->date('data')->nullable();
            $table->string('nome', 100)->nullable();
            $table->string('assunto', 30)->nullable();

            $table->string('fonte', 4)->nullable();
            $table->largeText('anexos')->nullable();
            $table->largeText('local')->nullable();

            $table->mediumText('descricao')->nullable();
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
        Schema::dropIfExists('facts');
    }
};
