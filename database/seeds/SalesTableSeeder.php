<?php

use Illuminate\Database\Seeder;

class SalesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public static function generateRandomString($length = 10, $numbresOnly=false) {
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $numbers="0123456789";
      $charactersLength = strlen($characters);
      $numbersLength = strlen($numbers);
      $randomString = '';
      if(!$numbresOnly){
       for ($i = 0; $i < $length; $i++) {
         $randomString .= $characters[rand(0, $charactersLength - 1)];
       }
      }
      else{
        for ($i = 0; $i < 4; $i++) {
          $randomString .= $numbers[rand(0, $numbersLength - 1)];
        }
      }
      return $randomString;
    }

    public function run()
    {

      $sales = [
          [
            'observation' => SalesTableSeeder::generateRandomString(10),
            'client' => 1,
            'seller' => 1,
            'supervisor' => 1,
            'analyst' => 1,
            'biker' => null,
            'delivery_address' => 'Guayana',
            'delivery_region' => 1,
            'delivery_commune' => 1,
            'delivery_phone' => '584126992473',
            'delivery_geographic_location' => SalesTableSeeder::generateRandomString(10),
            'delivery_observation' => SalesTableSeeder::generateRandomString(10),
            "chip_price" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "delivery_price" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "activation_price" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "claro_debt" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "agreement_footer" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "advance_charge" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "total" => (integer) SalesTableSeeder::generateRandomString(10,true),
            'substate' => 1,
          ],
          [
            'observation' => SalesTableSeeder::generateRandomString(10),
            'client' => 2,
            'seller' => 4,
            'supervisor' => 1,
            'analyst' => 2,
            'biker' => 3,
            'delivery_address' => 'Guayana',
            'delivery_region' => 1,
            'delivery_commune' => 1,
            'delivery_phone' => '584146902273',
            'delivery_geographic_location' => SalesTableSeeder::generateRandomString(10),
            'delivery_observation' => SalesTableSeeder::generateRandomString(10),
            "chip_price" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "delivery_price" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "activation_price" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "claro_debt" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "agreement_footer" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "advance_charge" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "total" => (integer) SalesTableSeeder::generateRandomString(10,true),
            'substate' => 1,
          ],
          [
            'observation' => SalesTableSeeder::generateRandomString(10),
            'client' => 3,
            'seller' => 4,
            'supervisor' => 1,
            'analyst' => 3,
            'biker' => null,
            'delivery_address' => 'Chile',
            'delivery_region' => 1,
            'delivery_commune' => 1,
            'delivery_phone' => '584146908463',
            'delivery_geographic_location' => SalesTableSeeder::generateRandomString(10),
            'delivery_observation' => SalesTableSeeder::generateRandomString(10),
            "chip_price" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "delivery_price" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "activation_price" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "claro_debt" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "agreement_footer" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "advance_charge" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "total" => (integer) SalesTableSeeder::generateRandomString(10,true),
            'substate' => 1,
          ],
          [
            'observation' => SalesTableSeeder::generateRandomString(10),
            'client' => 4,
            'seller' => 4,
            'supervisor' => 2,
            'analyst' => 3,
            'biker' => 2,
            'delivery_address' => 'Chile',
            'delivery_region' => 1,
            'delivery_commune' => 1,
            'delivery_phone' => '584146903673',
            'delivery_geographic_location' => SalesTableSeeder::generateRandomString(10),
            'delivery_observation' => SalesTableSeeder::generateRandomString(10),
            "chip_price" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "delivery_price" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "activation_price" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "claro_debt" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "agreement_footer" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "advance_charge" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "total" => (integer) SalesTableSeeder::generateRandomString(10,true),
            'substate' => 1,
          ],
          [
            'observation' => SalesTableSeeder::generateRandomString(10),
            'client' => 6,
            'seller' => 4,
            'supervisor' => 1,
            'analyst' => 2,
            'biker' => 3,
            'delivery_address' => 'Chile',
            'delivery_region' => 1,
            'delivery_commune' => 1,
            'delivery_phone' => '584146356273',
            'delivery_geographic_location' => SalesTableSeeder::generateRandomString(10),
            'delivery_observation' => SalesTableSeeder::generateRandomString(10),
            "chip_price" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "delivery_price" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "activation_price" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "claro_debt" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "agreement_footer" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "advance_charge" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "total" => (integer) SalesTableSeeder::generateRandomString(10,true),
            'substate' => 1,
          ],
          [
            'observation' => SalesTableSeeder::generateRandomString(10),
            'client' => 3,
            'seller' => 1,
            'supervisor' => 4,
            'analyst' => 3,
            'biker' => 1,
            'delivery_address' => 'Guayana',
            'delivery_region' => 1,
            'delivery_commune' => 1,
            'delivery_phone' => '584146998671',
            'delivery_geographic_location' => SalesTableSeeder::generateRandomString(10),
            'delivery_observation' => SalesTableSeeder::generateRandomString(10),
            "chip_price" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "delivery_price" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "activation_price" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "claro_debt" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "agreement_footer" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "advance_charge" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "total" => (integer) SalesTableSeeder::generateRandomString(10,true),
            'substate' => 1,
          ],
          [
            'observation' => SalesTableSeeder::generateRandomString(10),
            'client' => 2,
            'seller' => 4,
            'supervisor' => 1,
            'analyst' => 2,
            'biker' => 3,
            'delivery_address' => 'Guayana',
            'delivery_region' => 1,
            'delivery_commune' => 1,
            'delivery_phone' => '584146902273',
            'delivery_geographic_location' => SalesTableSeeder::generateRandomString(10),
            'delivery_observation' => SalesTableSeeder::generateRandomString(10),
            "chip_price" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "delivery_price" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "activation_price" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "claro_debt" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "agreement_footer" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "advance_charge" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "total" => (integer) SalesTableSeeder::generateRandomString(10,true),
            'substate' => 1,
          ],
          [
            'observation' => SalesTableSeeder::generateRandomString(10),
            'client' => 6,
            'seller' => 1,
            'supervisor' => 2,
            'analyst' => 3,
            'biker' => 4,
            'delivery_address' => 'Chile',
            'delivery_region' => 1,
            'delivery_commune' => 1,
            'delivery_phone' => '584146865842',
            'delivery_geographic_location' => SalesTableSeeder::generateRandomString(10),
            'delivery_observation' => SalesTableSeeder::generateRandomString(10),
            "chip_price" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "delivery_price" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "activation_price" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "claro_debt" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "agreement_footer" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "advance_charge" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "total" => (integer) SalesTableSeeder::generateRandomString(10,true),
            'substate' => 1,
          ],
          [
            'observation' => SalesTableSeeder::generateRandomString(10),
            'client' => 5,
            'seller' => 1,
            'supervisor' => 4,
            'analyst' => 2,
            'biker' => 3,
            'delivery_address' => 'Guayana',
            'delivery_region' => 1,
            'delivery_commune' => 1,
            'delivery_phone' => '584146856373',
            'delivery_geographic_location' => SalesTableSeeder::generateRandomString(10),
            'delivery_observation' => SalesTableSeeder::generateRandomString(10),
            "chip_price" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "delivery_price" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "activation_price" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "claro_debt" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "agreement_footer" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "advance_charge" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "total" => (integer) SalesTableSeeder::generateRandomString(10,true),
            'substate' => 1,
          ],
          [
            'observation' => SalesTableSeeder::generateRandomString(10),
            'client' => 4,
            'seller' => 4,
            'supervisor' => 2,
            'analyst' => 1,
            'biker' => null,
            'delivery_address' => 'Guayana',
            'delivery_region' => 1,
            'delivery_commune' => 1,
            'delivery_phone' => '584146862258',
            'delivery_geographic_location' => SalesTableSeeder::generateRandomString(10),
            'delivery_observation' => SalesTableSeeder::generateRandomString(10),
            "chip_price" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "delivery_price" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "activation_price" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "claro_debt" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "agreement_footer" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "advance_charge" => (integer) SalesTableSeeder::generateRandomString(9,true),
            "total" => (integer) SalesTableSeeder::generateRandomString(10,true),
            'substate' => 1,
          ],

      ];

      \DB::table('sales')->insert($sales);

    }
}
