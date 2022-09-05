<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRifasCompradasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rifas_compradas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('status', ['reservado', 'disponivel', 'comprado'])->default('disponivel');
            $table->string('cpf')->nullable();
            $table->string('celular')->nullable();
            $table->unsignedBigInteger('idComprador')->nullable();
            $table->unsignedBigInteger('idRifa')->nullable();
            $table->bigInteger('NumeroDaRifa');
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('idOP')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rifas_compradas');
    }
}
