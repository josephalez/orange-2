<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('plan')->unsigned();
            $table->bigInteger('equipment')->unsigned();
            $table->decimal('activation_price',11,2)->default(0);
            $table->decimal('prepaid_price',11,2)->default(0);
            $table->boolean("trash")->default(0);
            $table->boolean("active")->default(1);
            $table->timestamps();

            $table->foreign('plan')->references('id')->on('plans');
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
        Schema::dropIfExists('promotions');
    }
}
