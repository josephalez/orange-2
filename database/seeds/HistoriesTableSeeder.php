<?php

use Illuminate\Database\Seeder;

class HistoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      DB::table("histories")->insert([
        "title"=> 'Nueva venta creada con exito',
        "description"=> "Nueva venta creada con exito por el sistema",
        "icon"=> "fa fa-star",
        "sale"=> 1,
        "by"=> 1,
        "created_at"=> "1999-07-21 10:00:00.000000"
      ]);

      DB::table("histories")->insert([
        "title"=> 'Venta editada con exito por el sistema',
        "description"=> "Venta editada con exito por el sistema",
        "icon"=> "fa fa-pencil",
        "sale"=> 1,
        "by"=> 1,
        "created_at"=> "1999-08-21 10:00:00.000000"
      ]);

    }
}
