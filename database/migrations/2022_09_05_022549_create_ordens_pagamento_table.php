<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdensPagamentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordens_pagamento', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('amountUnidade');
            $table->integer('quantidadeCotas')->nullable();
            $table->unsignedBigInteger('telefoneComprador');
            $table->string('cpfComprador');
            $table->string('emailComprador');
            $table->string('nomeComprador');
            $table->unsignedBigInteger('idRifa')->nullable();
            $table->decimal('amount', 10);
            $table->enum('status', ['pendente', 'aprovada', 'perdida', 'rejeitada']);
            $table->dateTime('limiteOP');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ordens_pagamento');
    }
}
