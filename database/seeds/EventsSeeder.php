<?php

use Illuminate\Database\Seeder;

class EventsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("events")->insert([
          "title"=> 'Paris FinTech Forum',
          "description"=> "La capital francesa acogerá este mes a más de 150 CEOs de empresas ‘fintech’ de todo el mundo",
          "icon"=> "fa fa-times",
          "sale"=> 1,
          "notificationId"=> null,
          "by"=> 1,
          "for" => 2,
          "state"=> "alert",
          "oculto"=> 0,
          "trash"=> 0,
          "created_at"=> "1999-09-21 10:00:00.000000"
        ]);
        DB::table("events")->insert([
          "title"=> 'Future Digital Finance',
          "description"=> "Future Digital Finance reunirá en Florida a algunas de las mentes más brillantes del país para debatir sobre cómo transformar la experiencia del cliente",
          "icon"=> "fa fa-times",
          "sale"=> 2,
          "notificationId"=> null,
          "by"=> 2,
          "for" => 3,
          "state"=> "alert",
          "oculto"=> 0,
          "trash"=> 0,
          "created_at"=> "2000-09-21 11:00:00.000000"
        ]);
        DB::table("events")->insert([
          "title"=> 'Money20/20',
          "description"=> "Dividido en cuatro conferencias a lo largo del año y del planeta, Money20/20 supone una oportunidad para compartir nuevas ideas y explorar caminos disruptivos dentro del ecosistema de los servicios financieros.",
          "icon"=> "fa fa-times",
          "sale"=> 2,
          "notificationId"=> null,
          "by"=> 2,
          "for" => 3,
          "state"=> "alert",
          "oculto"=> 0,
          "trash"=> 0,
          "created_at"=> "2010-09-21 11:00:00.000000"
        ]);
    }
}
