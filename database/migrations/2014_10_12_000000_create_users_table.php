<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username',32)->unique();
            $table->string('password',180);
            $table->string("email",180)->unique();

            $table->string("name", 32);
            $table->string("last_name", 16); //paterno
            $table->string("last_name_2", 16)->nullable(); //materno
            $table->string("phone", 16)->nullable();

            $table->integer("comuna")->nullable()->unsigned();
            $table->foreign('comuna')->references('id')->on('communes');

            $table->string("address")->nullable();
            $table->string("education_level")->nullable();
            $table->date("birthday")->nullable();
            $table->enum("gender",["masculino","femenino","otro"])->nullable();
            $table->string("nationality")->nullable();
            $table->string("civil_status")->nullable();
            $table->string("rut", 12)->nullable();

            $table->bigInteger("assigned_to")->nullable()->unsigned(); // Vendedor
            $table->foreign("assigned_to")->references('id')->on('users'); //supervisor o backoffice

            $table->string('avatar')->nullable();

            $table->enum("role",[
              "usuario",
              "ejecutivo",
              "supervisor",
              "backoffice",
              "bodega",
              "backoffice_general",
              "rrhh",
              "mapa",
              "motorista",
              "bct",
              "lavadora",
              "admin"
            ])->default("usuario");

            $table->string("verify_token")->nullable();
            $table->string("slug", 70)->unique();
            $table->boolean("verifiedEmail")->default(0);

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
        Schema::dropIfExists('users');
    }
}
