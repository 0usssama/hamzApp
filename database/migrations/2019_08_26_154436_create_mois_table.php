<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mois', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('titre');
            $table->date('colutre_date')->nullable();
            $table->bigInteger('eleves_id')->unsigned();
            $table->bigInteger('payments_id')->unsigned()->nullable();
            $table->date('created_at')->nullable();
            $table->date('updated_at')->nullable();

            $table->foreign('eleves_id')->references('id')->on('eleves')->onDelete('cascade');
            $table->foreign('payments_id')->references('id')->on('payments')->onDelete('cascade');

           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mois');
    }
}
