<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type_seance');
            $table->string('etat_seance')->default('en attente');
            $table->bigInteger('mois_id')->unsigned();
            $table->date('cloture_date')->nullable();
            $table->timestamps();
            $table->foreign('mois_id')->references('id')->on('mois')->onDelete('cascade');;

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seances');
    }
}
