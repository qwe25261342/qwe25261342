<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiqueurSures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('liqueur_sures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('img');
            $table->string('contest');
            $table->integer('liqueur_product_id');
            $table->integer('year');
            $table->string('award');
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
        Schema::dropIfExists('liqueur_sures');
    }
}
