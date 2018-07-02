<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEscolhasCandidatosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('escolhas_candidato', function (Blueprint $table){
            $table->increments('id');
            $table->unsignedInteger('id_candidato');
            $table->foreign('id_candidato')->references('id_user')->on('users')->onDelete('cascade');
            $table->integer('programa_pretendido');
            $table->integer('area_pos')->default(0);
            $table->boolean('interesse_bolsa');
            $table->boolean('vinculo_empregaticio');
            $table->unsignedInteger('id_inscricao_verao');
            $table->foreign('id_inscricao_verao')->references('id_inscricao_verao')->on('configura_inscricao_verao')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('escolhas_candidato');
    }
}
