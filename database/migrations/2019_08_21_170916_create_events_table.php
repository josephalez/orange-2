<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 128);
            $table->string('description', 256);
            $table->string('icon', 32)->nullable();
            $table->bigInteger("sale")->nullable()->unsigned(); // Venta
            $table->foreign("sale")->references('id')->on('sales');
            $table->bigInteger("notificationId")->nullable()->unsigned();
            $table->bigInteger("by")->nullable()->unsigned(); //Quien la mando?
            $table->foreign("by")->references('id')->on('users');
            $table->bigInteger("for")->unsigned(); //Para quien?
            $table->foreign("for")->references('id')->on('users');
            $table->enum("state",["alert","viewed","click",])->default("alert");
            $table->boolean("oculto")->default(0);
            $table->boolean("trash")->default(0);
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
        Schema::dropIfExists('events');
    }
}
