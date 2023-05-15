<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRespondidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('respondidas', function (Blueprint $table) {
            $table->id();
            $table->integer('pontos')->nullable();
            $table->string('resposta', 255);
            $table->string('pergunta', 255);
            $table->unsignedBigInteger('categoria');
            $table->foreign('categoria')->references('id')->on('medias');
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
        Schema::dropIfExists('respondidas');
    }
}
