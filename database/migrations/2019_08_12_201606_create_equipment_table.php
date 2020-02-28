<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquipmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 48)->unique();
            $table->string('name', 48);
            $table->text('description')->nullable();
            $table->text('image')->nullable();
            $table->text('description_html')->nullable();            
            $table->string('mark', 24)->nullable();            
            $table->decimal('price',11,2)->default(0);    
            $table->text("details")->nullable();
                /* JSON Details:
                    -camera
                    -screen
                    -storage
                */
            $table->boolean("trash")->default(0); 
            $table->boolean("active")->default(1);
            $table->boolean("exception")->default(0);
            $table->boolean('is_html')->default(0);
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
        Schema::dropIfExists('equipments');
    }
}
