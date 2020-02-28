<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('imei',20)->unique();
            $table->string('sim',20)->nullable();
            $table->boolean('lost')->default(0);
            $table->string('office_guide')->nullable();
            $table->string('sku')->nullable();
            $table->string('color')->nullable();
            $table->boolean('trash')->default(0);
            $table->timestamps();

            $table->bigInteger('line')->unsigned()->nullable();
            $table->foreign('line')->references('id')->on('lines');

            $table->bigInteger('equipment')->unsigned();
            $table->foreign('equipment')->references('id')->on('equipments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stocks');
    }
}
