<?php

use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $people = [
            [1,'27.201.276','Hector','Ferrer','Cabrera','584126992473','Guayana, la churuata','27201276','2008-03-28','2008-03-12'],
            [2,'19.443.612-2','Parra','Valentina','Alicia','584126892473','Chile','194436122','2008-03-28','2008-03-28'],
            [3,'28.354.548-2','Dasilva','Juan','Carlos','584126992471','Chile','283545482','1999-04-11','1999-04-11'],
            [4,'26.344.798-2','Moreno','Ricardo','Jose','584123122971','Peru','263447982','2000-05-19','2000-05-19'],
            [5,'28.425.205-2','Mendez','Sara','Virginia','584126911819','Chile','284252052','1999-03-03','1999-03-03'],
            [6,'25.354.846-2','Navarro','Michille','Alejandra','58412591598','Chile','253548462','1999-11-10','1999-11-10'],
        ];

        $people = array_map(function($person) {
           return [
               'id' => $person[0],
               'rut' => $person[1],
               'name' => $person[2],
               'last_name' => $person[3],
               'last_name_2' => $person[4],
               'phone' => $person[5],
               'address' => $person[6],
               'carnet' => $person[7],
               'birthday' => $person[8],
               'carnet_expiration' => $person[9],
           ];
        }, $people);

        \DB::table('clients')->insert($people);
        
    }
}
