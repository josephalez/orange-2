<?php

use Illuminate\Database\Seeder;

class StatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("states")->insert([
            "id"=>'1',
            "name"=>"Planteamiento",
            "allowed_roles"=>'["ejecutivo","supervisor","backoffice","backoffice_general"]',
        ]);
        DB::table("states")->insert([
            "id"=>'2',
            "name"=>"Revisión",
            "allowed_roles"=>'["supervisor","backoffice","backoffice_general"]',
        ]);
        DB::table("states")->insert([
            "id"=>'3',
            "name"=>"Proceso",
            "allowed_roles"=>'["backoffice","backoffice_general"]',
        ]);
        DB::table("states")->insert([
            "id"=>'4',
            "name"=>"Recepción",
            "allowed_roles"=>'["bodega","backoffice","backoffice_general"]',
        ]);
        DB::table("states")->insert([
            "id"=>'5',
            "name"=>"Chequeo",
            "allowed_roles"=>'["backoffice","backoffice_general"]',
        ]);
        DB::table("states")->insert([
            "id"=>'6',
            "name"=>"SSTM Y EQUIPO EN BOLSA",
            "allowed_roles"=>'["mapa","backoffice","backoffice_general"]',
        ]);
        DB::table("states")->insert([
            "id"=>'7',
            "name"=>"En ruta",
            "allowed_roles"=>'["mapa","motorista","backoffice","backoffice_general"]',
        ]);
        DB::table("states")->insert([
            "id"=>'8',
            "name"=>"Terminada", //La venta ya no esta activa
            "allowed_roles"=>'["backoffice", "backoffice_general"]',
        ]);
        DB::table("states")->insert([
            "id"=>'9',
            "name"=>"Cancelada", //La venta ya no esta activa
            "allowed_roles"=>'["supervisor", "backoffice", "backoffice_general"]',
        ]);
        DB::table("states")->insert([
            "id"=>'10',
            "name"=>"Fallida", //La venta sigue activa...
            "allowed_roles"=>'["backoffice", "backoffice_general"]',
        ]);
    }
}
