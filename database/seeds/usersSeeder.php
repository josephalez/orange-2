<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class usersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public static function generateRandomString($length = 10) {
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $charactersLength = strlen($characters);
      $randomString = '';
      for ($i = 0; $i < $length; $i++) {
          $randomString .= $characters[rand(0, $charactersLength - 1)];
      }
      return $randomString;
    }

    public function run()
    {

        DB::table("users")->insert([
          "username"=> 'admin',
          "password"=> Hash::make('admin'),
          "email"=> "admin@admin.com",
          "name"=> 'Admin',
          "last_name"=> 'Sistema',
          "slug"=> "administrador-sistema",
          "gender" => rand(0, 1) ? 'masculino' : 'femenino',
          "role"=> "backoffice_general",
          "verifiedEmail"=> 1,
        ]);

        DB::table("users")->insert([
            "id"=> 2,
            "username"=> "Moncki",
            "password"=> Hash::make('27935371'),
            "email"=> "moncki21@gmail.com",
            "name"=> "Eduardo",
            "last_name"=> "Lara",
            "last_name_2"=> "Salazar",
            "phone"=> "04249104569",
            "comuna"=> 21,
            "address"=> "Villa Africana",
            "education_level"=> "Secundaria",
            "birthday"=> "1999/09/21",
            "gender"=> "masculino",
            "nationality"=> "Venezolana",
            "civil_status"=> "Soltero",
            "rut"=> "27935371",
            "assigned_to"=> 1,
            "role"=> "backoffice",
            "verify_token"=> "2y2h324hsa21as",
            "slug"=> "eduardolarasalazar",
            "verifiedEmail"=> 1,
            'avatar' => 'uploads/users/dev2.png'
        ]);

        DB::table("users")->insert([
            "id"=> 3,
            "username"=> "darens",
            "password"=> Hash::make('1234'),
            "email"=> "heasdas@gmail.com",
            "name"=> "Andres",
            "last_name"=> "Rodriguez",
            "last_name_2"=> "Salazar",
            "phone"=> "+512312412",
            "comuna"=> 21,
            "address"=> "villa africana",
            "education_level"=> "",
            "birthday"=> "1999/01/30",
            "gender"=> "masculino",
            "nationality"=> "Venezolano",
            "civil_status"=> "Soltero",
            "rut"=> "27506424",
            "assigned_to"=> 2,
            "role"=> "supervisor",
            "verify_token"=> "2y2h324hsa21as",
            "slug"=> "andres-rodrigues",
            "verifiedEmail"=> 1,
            'avatar' => 'uploads/users/dev.png'
        ]);

        DB::table("users")->insert([
            "id"=> 4,
            "username"=> "HectorXD",
            "password"=> Hash::make('martha2'),
            "email"=> "Hector1567XD@gmail.com",
            "name"=> "Hector",
            "last_name"=> "Ferrer",
            "last_name_2"=> "Cabrera",
            "phone"=> "+584126992473",
            "comuna"=> 20,
            "address"=> "Guayana",
            "education_level"=> "Bachillerato",
            "birthday"=> "2000/03/28",
            "gender"=> "masculino",
            "nationality"=> "Venezolano",
            "civil_status"=> "Soltero",
            "rut"=> "27201276",
            "assigned_to"=> 3,
            "role"=> "ejecutivo",
            "verify_token"=> "2y2h324ha21as2",
            "slug"=> "hector-ferrer",
            "verifiedEmail"=> 1,
        ]);

        DB::table("users")->insert([
          'id' => 9,
          "username"=> 'backoffice_general',
          "password"=> Hash::make('55555'),
          "email"=> "backoffice_general@backoffice_general.com",
          "name"=> 'Backoffice General',
          "last_name"=> 'Generico',
          "slug"=> "backoffice_general-generico",
          "gender" => rand(0, 1) ? 'masculino' : 'femenino',
          "role"=> "backoffice_general",
          "verifiedEmail"=> 1,
          'assigned_to' => null
        ]);

        DB::table("users")->insert([
          'id' => 10,
          "username"=> 'rrhh',
          "password"=> Hash::make('55555'),
          "email"=> "rrhh@rrhh.com",
          "name"=> 'Recursos Humanos',
          "last_name"=> 'Generico',
          "slug"=> "recursos_humanos-generico",
          "gender" => rand(0, 1) ? 'masculino' : 'femenino',
          "role"=> "rrhh",
          "verifiedEmail"=> 1,
          'assigned_to' => null
        ]);

        DB::table("users")->insert([
          'id' => 5,
          "username"=> 'backoffice',
          "password"=> Hash::make('55555'),
          "email"=> "backoffice@backoffice.com",
          "name"=> 'Backoffice',
          "last_name"=> 'Generico',
          "slug"=> "backoffice-generico",
          "gender" => rand(0, 1) ? 'masculino' : 'femenino',
          "role"=> "backoffice",
          "verifiedEmail"=> 1,
          'assigned_to' => 9
        ]);

        DB::table("users")->insert([
          'id' => 6,
          "username"=> 'supervisor',
          "password"=> Hash::make('55555'),
          "email"=> "supervisor@supervisor.com",
          "name"=> 'Supervisor',
          "last_name"=> 'Generico',
          "slug"=> "supervisor-generico",
          "gender" => rand(0, 1) ? 'masculino' : 'femenino',
          "role"=> "supervisor",
          "verifiedEmail"=> 1,
          'assigned_to' => 5
        ]);

        DB::table("users")->insert([
          'id' => 7,
          "username"=> 'ejecutivo',
          "password"=> Hash::make('55555'),
          "email"=> "ejecutivo@ejecutivo.com",
          "name"=> 'Ejecutivo',
          "last_name"=> 'Generico',
          "slug"=> "ejecutivo-generico",
          "gender" => rand(0, 1) ? 'masculino' : 'femenino',
          "role"=> "ejecutivo",
          "verifiedEmail"=> 1,
          'assigned_to' => 6
        ]);

        DB::table("users")->insert([
          'id' => 8,
          "username"=> 'bodega',
          "password"=> Hash::make('55555'),
          "email"=> "bodega@bodega.com",
          "name"=> 'Bodega',
          "last_name"=> 'Generico',
          "slug"=> "bodega-generico",
          "gender" => rand(0, 1) ? 'masculino' : 'femenino',
          "role"=> "bodega",
          "verifiedEmail"=> 1,
          'assigned_to' => null
        ]);


        $roles = ['ejecutivo','supervisor','backoffice'];

        for ($i=0; $i < 50; $i++) {
          $role = $roles[array_rand($roles, 1)];

          DB::table("users")->insert([
              "username"=> usersSeeder::generateRandomString(6)."-test".$i,
              "password"=> Hash::make('martha2'),
              "email"=> "user-$i@test.com",
              "name"=> $role.' '.usersSeeder::generateRandomString(7),
              "last_name"=> usersSeeder::generateRandomString(6)." ".$i,
              "slug"=> $role."-test-".$i,
              "gender" => rand(0, 1) ? 'masculino' : 'femenino',
              'role' => $role
          ]);

        }

    }
}
