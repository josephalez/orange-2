<?php

use Illuminate\Database\Seeder;

class EquipamentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $equipments = [[
            'id' => 1, 
            'code' => "one_plus_7t",
            'name' => "One Plus 7T",
            'description' => "OnePlus 7 Pro Dual Sim Factory GM1917 8 GB + 256 GB Nebula Blue (ATT, Verizon, Tmobile)",
            'image' => "uploads/devices/OnePlus7t.jpg",
            'description_html' => "",
            'mark' => "One Plus",
            'price' => 889.990,
            'details' => json_encode([
                'screen' => [
                    'height' => 3120,
                    'width' => 1440 
                ],
                'camera' => 48,
                'storage' => 256 
            ]), 
            'trash' => 0,
            'active' => 1,
            'exception' => 1,
            'is_html' => 0
        ],[
            'id' => 2, 
            'code' => "one_plus_6t",
            'name' => "One Plus 6T",
            'description' => "OnePlus 6T A6013 128GB Mirror Black - US Version T-Mobile GSM Unlocked Phone (Renewed)",
            'image' => "uploads/devices/OnePlus6t.jpg",
            'description_html' => "",
            'mark' => "One Plus",
            'price' => 356.950,
            'details' => json_encode([
                'screen' => [
                    'height' => 2340,
                    'width' => 1080 
                ],
                'camera' => 20,
                'storage' =>  128
            ]), 
            'trash' => 0,
            'active' => 1,
            'exception' => 0,
            'is_html' => 0
        ],[
            'id' => 3, 
            'code' => "huawei_p30_pro",
            'name' => "Huawei P30 Pro",
            'description' => "
            Huawei P30 Pro 256GB+8GB RAM (VOG-L29) 40MP LTE Factory Unlocked GSM Smartphone (International Version, No Warranty in the US) (Aurora)",
            'image' => "uploads/devices/Huaweip30pro.jpg",
            'description_html' => "",
            'mark' => "Huawei",
            'price' => 819.000,
            'details' => json_encode([
                'screen' => [
                    'height' => 2340,
                    'width' => 1080
                ],
                'camera' => 40,
                'storage' => 256  
            ]), 
            'trash' => 0,
            'active' => 0,
            'exception' => 0,
            'is_html' => 0
        ],[
            'id' => 4, 
            'code' => "huawei_y221",
            'name' => "Huawei Y221",
            'description' => "",
            'image' => "uploads/devices/HuaweiY220.jpg",
            'description_html' => "",
            'mark' => "Huawei",
            'price' => 50990,
            'details' => json_encode([
                'screen' => [
                    'height' => 480,
                    'width' => 320
                ],
                'camera' => 2,
                'storage' => 0.512
            ]), 
            'trash' => 1,
            'active' => 1,
            'exception' => 0,
            'is_html' => 0
        ],[
            'id' => 5, 
            'code' => "lenovo_a916",
            'name' => "Lenovo A916",
            'description' => "",
            'image' => "uploads/devices/LenovoA916.png",
            'description_html' => "", 
            'mark' => "Lenovo",
            'price' => 150.990,
            'details' => json_encode([
                'screen' => [
                    'height' => 1280,
                    'width' => 720  
                ],
                'camera' => 11,
                'storage' => 8 
            ]), 
            'trash' => 1,
            'active' => 1,
            'exception' => 1,
            'is_html' => 0
        ],[
            'id' => 6, 
            'code' => "samsung_galaxy_note9",
            'name' => "Samsung Galaxy Note9",
            'description' => "Samsung Galaxy Note9 N960U 128GB Unlocked 4G LTE Phone w/ Dual 12MP Camera - Midnight Black",
            'image' => "uploads/devices/Note9.jpg",
            'description_html' => "<h1>Hello</h1>",
            'mark' => "Samsung Galaxy",
            'price' => 698.870,
            'details' => json_encode([
                'screen' => [
                    'height' => 2960,
                    'width' => 1440 
                ],
                'camera' => 12,
                'storage' => 128 
            ]), 
            'trash' => 0,
            'active' => 1,
            'exception' => 1,
            'is_html' => 1,
        ]];
        \DB::table('equipments')->insert($equipments);
    }
}
