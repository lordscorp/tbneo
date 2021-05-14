<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjetosTable extends Migration
{
    /**
     * Executa as migrations.
     *
     * @return void
     */
    public function up()
    {
        // Cria tabela Projetos
        Schema::create('projetos', function (Blueprint $table) {
            $table->id();
            $table->string('nome_projeto');
            $table->string('descricao')->nullable();
            $table->string('url_jira')->nullable();
            $table->foreignId('criado_por')->constrained('users');
            $table->foreignId('atualizado_por')->constrained('users');
            $table->timestamps();
        });

        // Cria tabela Features
        Schema::create('features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('projeto_id')->constrained();
            $table->string('nome_feature');
            $table->string('url');
            $table->timestamps();
        });
        
        // Cria tabela de Log
        Schema::create('logs', function (Blueprint $table){
            $table->id();
            $table->foreignId('projeto_id')->constrained();
            $table->string('propriedade_alterada');
            $table->string('alteracao_realizada');
            $table->string('valor_anterior')->nullable();;
            $table->string('valor_novo')->nullable();;
            $table->foreignId('alterado_por')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverte as migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log');
        Schema::dropIfExists('features');
        Schema::dropIfExists('projetos');
    }
}
