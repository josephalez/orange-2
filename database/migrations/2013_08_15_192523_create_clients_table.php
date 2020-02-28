<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('rut',16)->unique();
            $table->string("name", 32)->nullable();
            $table->string("email", 190)->nullable();
            $table->string("last_name",16)->nullable(); //paterno
            $table->string("last_name_2",16)->nullable(); //materno
            $table->string("phone", 16)->nullable();
            $table->string("address")->nullable();
            $table->string("carnet",16)->nullable();
            $table->date("birthday")->nullable();
            $table->date("carnet_expiration")->nullable();

            $table->enum("type",[
              "persona",
              "empresario",
              "pyme",
              "compañia",
              "corporacion"
            ])->nullable();

            $table->integer("comuna")->nullable()->unsigned();
            $table->foreign("comuna")->references('id')->on('communes');

            $table->enum("class",[
              "normal",
              "bci",
            ])->nullable();

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
        Schema::dropIfExists('clients');
    }
}
