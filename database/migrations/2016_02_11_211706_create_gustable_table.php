<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGustableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // gustable_tipo: el modelo a dar me gusta
        // gustable_id: CP de la tabla correspondiente al modelo
        Schema::create('gustable', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('usuario_id');
            $table->integer('gustable_id');
            $table->string('gustable_type');
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
        Schema::drop('gustable');
    }
}
