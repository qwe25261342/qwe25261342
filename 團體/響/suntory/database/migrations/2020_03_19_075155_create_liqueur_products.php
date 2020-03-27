<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiqueurProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('liqueur_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('liqueur_id');
            $table->string('img');
            $table->string('content');
            $table->string('title');
            $table->string('capacity');
            $table->string('density');
            $table->string('color');
            $table->string('aroma');
            $table->string('body');
            $table->string('taste');
            $table->string('aftertaste');
            $table->integer('price');
            $table->string('note')->nullable();
            $table->integer('sort')->default(0);
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
        Schema::dropIfExists('liqueur_products');
    }
}
