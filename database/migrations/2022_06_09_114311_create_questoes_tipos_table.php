<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestoesTiposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questoes_tipos', function (Blueprint $table) {
            $table->unsignedBigInteger('questoes_id');
            $table->foreign('questoes_id')->references('id')->on('questoes');
            $table->unsignedBigInteger('tipos_id');
            $table->foreign('tipos_id')->references('id')->on('tipos');
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
        Schema::dropIfExists('questoes_tipos');
    }
}
