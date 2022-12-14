<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRifasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rifas', function (Blueprint $table) {
            $table->id();
            $table->string("nome_da_rifa");
            $table->string("descricao_curta");
            $table->text("imagens_sorteio");
            $table->text("descricao_completa");
            $table->double('valor_da_cota', 8, 2);
            $table->enum("status_rifa",["ativa","apurando","finalizada"]);
            $table->enum("forma_da_rifa",["finalmanual","finalcomqtdcotas"]);
            $table->bigInteger("fim_de_cotas")->nullable();
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
        Schema::dropIfExists('rifas');
    }
}
