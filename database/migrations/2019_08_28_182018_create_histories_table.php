<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 128);
            $table->string('description', 256);
            $table->string('icon', 32)->nullable();
            $table->bigInteger('sale')->nullable()->unsigned(); // Venta
            $table->foreign('sale')->references('id')->on('sales');
            $table->bigInteger("by")->nullable()->unsigned(); //Quien la mando?
            $table->foreign("by")->references('id')->on('users');
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
        Schema::dropIfExists('histories');
    }
}
