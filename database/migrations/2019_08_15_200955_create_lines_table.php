<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger("sale")->nullable()->unsigned(); // Venta
            $table->foreign("sale")->references('id')->on('sales');
            $table->string("pcs")->nullable();
            $table->string("imei")->nullable();
            $table->string("sim")->nullable();
            $table->bigInteger("plan")->nullable()->unsigned(); // Plan
            $table->foreign("plan")->references('id')->on('plans');
            $table->bigInteger("equipment")->nullable()->unsigned(); // Plan
            $table->foreign("equipment")->references('id')->on('equipments');
            $table->float('plan_cost')->nullable();
            $table->float('price')->nullable(); //total value
            $table->integer('fees')->nullable();//Cuotas de pago
            $table->float('chip_price')->nullable();
            $table->bigInteger("substate")->unsigned();
            $table->foreign("substate")->references('id')->on('substates');
            /*--------------------Fechas--------------------*/
            $table->date('creation')->nullable();
            $table->date('executive_send')->nullable();
            $table->date('supervisor_send')->nullable();
            $table->date('warehouse_send')->nullable();
            $table->date('map_assigned_biker')->nullable();
            $table->date('biker_send')->nullable();
            $table->date('ok')->nullable();
            $table->date('sstm')->nullable();
            $table->date('finalization')->nullable();
            /*----------------------------------------------*/

            $table->enum("donor_company",[
            "none",
            "wom",
            "entel",
            "vtr",
            "claro",
            "virgin",
            "movistar"
            ])->nullable();

            $table->enum("type",[
            "none",
            "nueva_linea",
            "migracion",
            "portabilidad",
            "bam"
            ])->nullable();

            $table->boolean("canceled")->default(0);

            $table->enum("ambit",[
            "none",
            "fisica",
            "digital",
            "ambas",
            "otro"
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
        Schema::dropIfExists('lines');
    }
}
