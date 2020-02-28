<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('observation')->nullable();
            $table->bigInteger("client")->unsigned(); // Cliente
            $table->foreign("client")->references('id')->on('clients');

            /*--------------Datos del Sistema--------------*/
            $table->bigInteger("seller")->nullable()->unsigned(); // Vendedor
            $table->foreign("seller")->references('id')->on('users');
            $table->bigInteger("supervisor")->nullable()->unsigned();
            $table->foreign("supervisor")->references('id')->on('users');
            $table->bigInteger("analyst")->nullable()->unsigned();
            $table->foreign("analyst")->references('id')->on('users');
            $table->bigInteger("biker")->nullable()->unsigned(); //Motorista
            $table->foreign("biker")->references('id')->on('users');
            /*---------------------------------------------*/

            /*--------------Datos del Sistema--------------*/
            $table->string("delivery_address")->nullable();
            $table->integer("delivery_region")->nullable()->unsigned();
            $table->foreign('delivery_region')->references('id')->on('regions');
            $table->integer("delivery_commune")->nullable()->unsigned();
            $table->foreign('delivery_commune')->references('id')->on('communes');
            $table->string("delivery_phone", 16)->nullable();
            $table->dateTime("delivery_initial_time")->nullable(); //Fusion de delivery date y la hora inicial
            $table->dateTime("delivery_final_time")->nullable(); //Fusion de delivery date y la hora final
            $table->string("delivery_geographic_location")->nullable();
            $table->string("delivery_observation")->nullable(); //Observacion del cliente
            /*----------------------------------------------*/

            /*--------------Valores Numericos---------------*/
            $table->decimal("chip_price",12,2)->default(0); //Total del chip (numerio de lineas x 3990)
            $table->decimal("delivery_price",12,2)->default(0); //Valor despacho (valor cualquiera)
            $table->decimal("activation_price",12,2)->default(0); //Cargo de activacion (creo que es la suma del coste de activacion de los planes)
            $table->decimal("claro_debt",12,2)->default(0); //Deuda Claro (coste cualquiera)
            $table->decimal("agreement_footer",12,2)->default(0); //Pie de convenio (coste cualquiera)
            $table->decimal("advance_charge",12,2)->default(0); //Cargo Anticipado (cualquiera)
            $table->decimal("total",14,3)->default(0); //Total del todo ¿?¿?¿? <- si

            /*Decimal 12,2:*/
            // -Permite 12 Numeros en total.
            // -Hasta 9 enteros
            // -Hasta 2 decimales

            /*Decimal 14,3:*/
            // -Permite 14 Numeros en total.
            // -Hasta 10 enteros
            // -Hasta 3 decimales

            /*----------------------------------------------*/

            /*--------------------JSONS---------------------*/
            $table->text("other_data")->nullable();
            $table->text("metadata")->nullable();
            /*----------------------------------------------*/ //Subestado general?
            $table->bigInteger("substate")->nullable()->unsigned();
            $table->foreign("substate")->references('id')->on('substates');

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
        Schema::dropIfExists('sales');
    }
}
