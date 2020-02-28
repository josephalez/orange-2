<?php

use Illuminate\Database\Seeder;

class SubstatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table("substates")->insert([
            "id"=>'1',
            "name"=>"SIN ACCIONES",
            "state"=>"1"

        ]);
        DB::table("substates")->insert([
            "id"=>'2',
            "name"=>"DEVUELTA AL EJECUTIVO",
            "state"=>"1"

        ]);
        DB::table("substates")->insert([
            "id"=>'3',
            "name"=>"ENVIADA AL SUPERVISOR",
            "state"=>"2"

        ]);
        DB::table("substates")->insert([
            "id"=>'4',
            "name"=>"RECHAZADA POR BACKOFFICE",
            "state"=>"2"
        ]);
        DB::table("substates")->insert([
            "id"=>'5',
            "name"=>"EN PROCESO DE ANALISIS",
            "state"=>"3"
        ]);
        DB::table("substates")->insert([
            "id"=>'6',
            "name"=>"PENDIENTE BODEGA",
            "state"=>"4"

        ]);
        DB::table("substates")->insert([
            "id"=>'7',
            "name"=>"BODEGA OK",
            "state"=>"5"

        ]);
        DB::table("substates")->insert([
            "id"=>'8',
            "name"=>"PENDIENTE RUTA",
            "state"=>"6"

        ]);
        DB::table("substates")->insert([
            "id"=>'9',
            "name"=>"RUTA SANTIAGO",
            "state"=>"7"

        ]);
        DB::table("substates")->insert([
            "id"=>'10',
            "name"=>"RUTA VIÑA",
            "state"=>"7"

        ]);
        DB::table("substates")->insert([
            "id"=>'11',
            "name"=>"RUTA LA SEREÑA",
            "state"=>"7"
        ]);
        DB::table("substates")->insert([
            "id"=>'12',
            "name"=>"RUTA RANCAGUA",
            "state"=>"7"

        ]);
        DB::table("substates")->insert([
            "id"=>'13',
            "name"=>"RUTA CONCEPCION",
            "state"=>"7"

        ]);
        DB::table("substates")->insert([
            "id"=>'14',
            "name"=>"RUTA LA SEREÑA",
            "state"=>"7"

        ]);
        DB::table("substates")->insert([
            "id"=>'15',
            "name"=>"COMPLETADA",
            "state"=>"8"

        ]);
        DB::table("substates")->insert([
            "id"=>'16',
            "name"=>"CANCELADA",
            "state"=>"9"

        ]);

    }
}
