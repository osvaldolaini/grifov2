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
        Schema::create('registers', function (Blueprint $table) {
            $table->id();
            $table->boolean('active')->nullable();
            $table->foreignId('registers_types_id')->constrained();
            $table->string('tipo', 100)->nullable();
            $table->string('nome', 100)->nullable();
            $table->string('codNome', 100)->nullable();
            $table->string('sexo', 30)->nullable();
            $table->string('especialidade', 30)->nullable();
            $table->string('postoGrad', 30)->nullable();
            $table->date('nascimento')->nullable();
            $table->string('nacionalidade', 100)->nullable();
            $table->string('naturalidade', 100)->nullable();

            $table->string('parentesco', 1000)->nullable();
            $table->string('contatos', 1000)->nullable();
            $table->string('enderecos', 1000)->nullable();
            $table->string('pai', 100)->nullable();
            $table->string('mae', 100)->nullable();

            $table->string('cep', 100)->nullable();
            $table->string('celular', 100)->nullable();
            $table->string('fixo', 100)->nullable();
            $table->string('rg', 100)->nullable();
            $table->string('cpf', 100)->nullable();
            $table->string('passaporte', 100)->nullable();
            $table->integer('militar')->nullable();
            $table->integer('estrangeiro')->nullable();
            $table->string('saram', 8)->nullable();
            $table->string('imagem', 255)->nullable();

            $table->mediumText('obs')->nullable();
            $table->mediumText('palavraChave')->nullable();

            $table->string('pais', 100)->nullable();
            $table->string('cnpj')->nullable();

            $table->string('aeronave_prefixo')->nullable();
            $table->string('aeronave_proprietario')->nullable();
            $table->string('aeronave_outros_proprietarios')->nullable();
            $table->string('aeronave_sg_uf', 20)->nullable();
            $table->string('aeronave_cpf_cnpj')->nullable();
            $table->string('aeronave_nm_operador')->nullable();
            $table->string('aeronave_outros_operadores')->nullable();
            $table->string('aeronave_uf_operador', 20)->nullable();
            $table->string('aeronave_cpf_cgc')->nullable();
            $table->string('aeronave_nr_cert_matricula')->nullable();
            $table->string('aeronave_nr_serie')->nullable();
            $table->string('aeronave_cd_categoria')->nullable();
            $table->string('aeronave_cd_tipo')->nullable();
            $table->string('aeronave_ds_modelo')->nullable();
            $table->string('aeronave_nm_fabricante')->nullable();
            $table->string('aeronave_cd_tipo_icao')->nullable();
            $table->integer('aeronave_nr_passageiros_max')->nullable();
            $table->string('aeronave_cd_marca_estrangeira')->nullable();
            $table->date('aeronave_dt_matricula')->nullable();

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
        Schema::dropIfExists('registers');
    }
};
