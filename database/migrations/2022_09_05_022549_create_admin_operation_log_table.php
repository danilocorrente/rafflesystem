<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminOperationLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_operation_log', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index();
            $table->string('path');
            $table->string('method', 10);
            $table->string('ip');
            $table->text('input');
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
        Schema::dropIfExists('admin_operation_log');
    }
}
