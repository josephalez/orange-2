<?php

use Illuminate\Database\Seeder;

class PromotionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $promotions = [[ 
            'id' => 1,
            'plan' => 1, 
            'equipment' => 1, 
            'activation_price' => 84.990,
            'prepaid_price' => 21.990, 
            'trash' => 0, 
            'active' => 1
        ],[
            'id' => 2,
            'plan' => 2, 
            'equipment' => 1, 
            'activation_price' => 92.990,
            'prepaid_price' => 26.990, 
            'trash' => 0, 
            'active' => 1
        ],[
            'id' => 3,
            'plan' => 3, 
            'equipment' => 1, 
            'activation_price' => 54.990,
            'prepaid_price' => 18.99, 
            'trash' => 0, 
            'active' => 1
        ],[
            'id' => 4,
            'plan' => 4, 
            'equipment' => 1, 
            'activation_price' => 74.990,
            'prepaid_price' => 24.990, 
            'trash' => 0, 
            'active' => 1
        ],[
            'id' => 5,
            'plan' => 5, 
            'equipment' => 1, 
            'activation_price' => 27.990,
            'prepaid_price' => 9.990, 
            'trash' => 1, 
            'active' => 1
        ],[
            'id' => 6,
            'plan' => 6, 
            'equipment' => 1, 
            'activation_price' => 14.990,
            'prepaid_price' => 44.990, 
            'trash' => 0, 
            'active' => 0
        ],[
            'id' => 7,
            'plan' => 1, 
            'equipment' => 2, 
            'activation_price' => 84.990,
            'prepaid_price' => 21.990, 
            'trash' => 0, 
            'active' => 1
        ],[
            'id' => 8,
            'plan' => 2, 
            'equipment' => 2, 
            'activation_price' => 92.990,
            'prepaid_price' => 26.990, 
            'trash' => 0, 
            'active' => 1
        ],[
            'id' => 9,
            'plan' => 3, 
            'equipment' => 3, 
            'activation_price' => 54.990,
            'prepaid_price' => 18.99, 
            'trash' => 0, 
            'active' => 1
        ],[
            'id' => 10,
            'plan' => 2, 
            'equipment' => 3, 
            'activation_price' => 92.990,
            'prepaid_price' => 26.990, 
            'trash' => 0, 
            'active' => 1
        ],[
            'id' => 11,
            'plan' => 5, 
            'equipment' => 5, 
            'activation_price' => 27.990,
            'prepaid_price' => 9.990,
            'trash' => 0, 
            'active' => 1
        ],[
            'id' => 12,
            'plan' => 6, 
            'equipment' => 5, 
            'activation_price' => 44.990,
            'prepaid_price' => 14.990, 
            'trash' => 0, 
            'active' => 1
        ],[
            'id' => 13,
            'plan' => 1, 
            'equipment' => 6, 
            'activation_price' => 84.990,
            'prepaid_price' => 21.990, 
            'trash' => 1, 
            'active' => 1
        ],[
            'id' => 14,
            'plan' => 1, 
            'equipment' => 6, 
            'activation_price' => 84.990,
            'prepaid_price' => 21.990, 
            'trash' => 0, 
            'active' => 1
        ],[
            'id' => 15,
            'plan' => 1, 
            'equipment' => 6, 
            'activation_price' => 84.990,
            'prepaid_price' => 21.990, 
            'trash' => 0, 
            'active' => 0
        ],[
            'id' => 16,
            'plan' => 5, 
            'equipment' => 3, 
            'activation_price' => 27.990,
            'prepaid_price' => 9.990, 
            'trash' => 0, 
            'active' => 1
        ],[
            'id' => 17,
            'plan' => 6, 
            'equipment' => 3, 
            'activation_price' => 44.990,
            'prepaid_price' => 14.990, 
            'trash' => 0, 
            'active' => 1
        ],[
            'id' => 18,
            'plan' => 5, 
            'equipment' => 6, 
            'activation_price' => 27.990,
            'prepaid_price' => 9.990, 
            'trash' => 1, 
            'active' => 1 
        ]];
        \DB::table('promotions')->insert($promotions);

    }
}
