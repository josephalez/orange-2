<?php

use Illuminate\Database\Seeder;

class PlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plans = [[
            'id' => 1,
            'name' => 'Plan l port', 
            'price' => 21.990, 
            'activation_price' => 84.990, 
            'points' => 2,
            'trash' => 0,  
            'active' => 1
        ],[
            'id' => 2,
            'name' => 'Plan lx port', 
            'price' => 26.990, 
            'activation_price' => 92.990, 
            'points' => 2,
            'trash' => 0, 
            'active' => 1
        ],[
            'id' => 3,
            'name' => 'Plan l ep port', 
            'price' => 18.990, 
            'activation_price' => 54.990, 
            'points' => 1,
            'trash' => 0, 
            'active' => 1
        ],[
            'id' => 4, 
            'name' => 'Plan lx ep port', 
            'price' => 24.990, 
            'activation_price' => 74.990, 
            'points' => 2,
            'trash' => 0, 
            'active' => 1
        ],[
            'id' => 5,
            'name' => 'Plan s ep ce port', 
            'price' => 9.990, 
            'activation_price' => 27.990, 
            'points' => 1,
            'trash' => 0, 
            'active' => 0
        ],[
            'id' => 6,
            'name' => 'Plan m ep ce port', 
            'price' => 14.990, 
            'activation_price' => 44.990, 
            'points' => 1,
            'trash' => 1, 
            'active' => 1
        ]];

        \DB::table('plans')->insert($plans);
    }
}
