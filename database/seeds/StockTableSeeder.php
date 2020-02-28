<?php

use Illuminate\Database\Seeder;

class StockTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stock = [[
            'id' => 1,
            'imei' => "1234567890123001",
            'sim' => "1234567890123201",
            'equipment' => 1,
            'lost' => 0,
            'line' => null,
            'office_guide' => "12345601",
            'sku' => '12345678901301',
            'color' => 'negro',
            'trash' => 0
        ],[
            'id' => 2,
            'imei' => "1234567890123002",
            'sim' => '1234567890123202',
            'equipment' => 1,
            'lost' => 0,
            'line' => null,
            'office_guide' => '12345602',
            'sku' => '1234567890123302',
            'color' => 'azul',
            'trash' => 0
        ],[
            'id' => 3,
            'imei' => '1234567890123003',
            'sim' => '1234567890123203',
            'equipment' => 1,
            'lost' => 0,
            'line' => null,
            'office_guide' => '12345603',
            'sku' => '1234567890123303',
            'color' => 'verde',
            'trash' => 1
        ],[
            'id' => 4,
            'imei' => '1234567890123004',
            'sim' => '1234567890123204',
            'equipment' => 2,
            'lost' => 0,
            'line' => null,
            'office_guide' => '12345604',
            'sku' => '1234567890123304',
            'color' => 'negro',
            'trash' => 0
        ],[
            'id' => 5,
            'imei' => '1234567890123005',
            'sim' => '1234567890123205',
            'equipment' => 2,
            'lost' => 0,
            'line' => null,
            'office_guide' => '12345605',
            'sku' => '1234567890123305',
            'color' => 'morado',
            'trash' => 0
        ],[
            'id' => 6,
            'imei' => '1234567890123006',
            'sim' => '1234567890123206',
            'equipment' => 2,
            'lost' => 0,
            'line' => null,
            'office_guide' => '12345606',
            'sku' => '1234567890123306',
            'color' => 'gris',
            'trash' => 0
        ],[
            'id' => 7,
            'imei' => '1234567890123007',
            'sim' => '1234567890123207',
            'equipment' => 3,
            'lost' => 0,
            'line' => null,
            'office_guide' => '12345607',
            'sku' => '1234567890123307',
            'color' => 'morado',
            'trash' => 0
        ],[
            'id' => 8,
            'imei' => '1234567890123008',
            'sim' => '1234567890123208',
            'equipment' => 3,
            'lost' => 0,
            'line' => null,
            'office_guide' => '12345608',
            'sku' => '1234567890123308',
            'color' => 'negro',
            'trash' => 0
        ],[
            'id' => 9,
            'imei' => '1234567890123009',
            'sim' => '1234567890123209',
            'equipment' => 3,
            'lost' => 0,
            'line' => null,
            'office_guide' => '12345609',
            'sku' => '1234567890123309',
            'color' => 'gris',
            'trash' => 0
        ],[
            'id' => 10,
            'imei' => '1234567890123010',
            'sim' => '1234567890123210',
            'equipment' => 4,
            'lost' => 0,
            'line' => null,
            'office_guide' => '12345610',
            'sku' => '1234567890123310',
            'color' => 'gris',
            'trash' => 0
        ],[
            'id' => 11,
            'imei' => '1234567890123011',
            'sim' => '1234567890123211',
            'equipment' => 4,
            'lost' => 0,
            'line' => null,
            'office_guide' => '12345611',
            'sku' => '1234567890123311',
            'color' => 'verde',
            'trash' => 0
        ],[
            'id' => 12,
            'imei' => '1234567890123012',
            'sim' => '1234567890123212',
            'equipment' => 4,
            'lost' => 0,
            'line' => null,
            'office_guide' => '12345612',
            'sku' => '1234567890123312',
            'color' => 'verde',
            'trash' => 0
        ],[
            'id' => 13,
            'imei' => '1234567890123013',
            'sim' => '1234567890123213',
            'equipment' => 5,
            'lost' => 0,
            'line' => null,
            'office_guide' => '12345613',
            'sku' => '1234567890123313',
            'color' => 'gris',
            'trash' => 0
        ],[
            'id' => 14,
            'imei' => '1234567890123014',
            'sim' => '1234567890123214',
            'equipment' => 5,
            'lost' => 0,
            'line' => null,
            'office_guide' => '12345614',
            'sku' => '1234567890123314',
            'color' => 'morado',
            'trash' => 0
        ],[
            'id' => 15,
            'imei' => '1234567890123015',
            'sim' => '1234567890123215',
            'equipment' => 5,
            'lost' => 0,
            'line' => null,
            'office_guide' => '12345615',
            'sku' => '1234567890123315',
            'color' => 'negro',
            'trash' => 0
        ],[
            'id' => 16,
            'imei' => '1234567890123016',
            'sim' => '1234567890123216',
            'equipment' => 6,
            'lost' => 0,
            'line' => null,
            'office_guide' => '12345616',
            'sku' => '1234567890123316',
            'color' => 'blanco',
            'trash' => 0
        ],[
            'id' => 17,
            'imei' => '1234567890123017',
            'sim' => '1234567890123217',
            'equipment' => 6,
            'lost' => 0,
            'line' => null,
            'office_guide' => '12345617',
            'sku' => '1234567890123317',
            'color' => 'blanco',
            'trash' => 0
        ],[
            'id' => 18,
            'imei' => '1234567890123018',
            'sim' => '1234567890123218',
            'equipment' => 6,
            'lost' => 0,
            'line' => null,
            'office_guide' => '12345618',
            'sku' => '1234567890123318',
            'color' => 'mordad',
            'trash' => 0
        ],[
            'id' => 19,
            'imei' => "12345523890123001",
            'sim' => "12312490123201",
            'equipment' => 1,
            'lost' => 0,
            'line' => null,
            'office_guide' => "12532601",
            'sku' => '123435238901301',
            'color' => 'negro',
            'trash' => 0
        ],[
            'id' => 20,
            'imei' => "125323890123001",
            'sim' => "1235320123201",
            'equipment' => 1,
            'lost' => 0,
            'line' => null,
            'office_guide' => "12532601",
            'sku' => '123435238901301',
            'color' => 'negro',
            'trash' => 0
        ],[
            'id' => 21,
            'imei' => "123456430123001",
            'sim' => "11230123201",
            'equipment' => 1,
            'lost' => 0,
            'line' => null,
            'office_guide' => "12532601",
            'sku' => '123435238901301',
            'color' => 'negro',
            'trash' => 0
        ],[
            'id' => 22,
            'imei' => "123456430155523001",
            'sim' => "112301523555201",
            'equipment' => 1,
            'lost' => 0,
            'line' => null,
            'office_guide' => "12532601",
            'sku' => '123435238901301',
            'color' => 'negro',
            'trash' => 0
        ],[
            'id' => 23,
            'imei' => "1235320123001",
            'sim' => "112301532201",
            'equipment' => 1,
            'lost' => 0,
            'line' => null,
            'office_guide' => "12532601",
            'sku' => '123435238901301',
            'color' => 'negro',
            'trash' => 0
        ],[
            'id' => 24,
            'imei' => "15321421401",
            'sim' => "5123",
            'equipment' => 1,
            'lost' => 0,
            'line' => null,
            'office_guide' => "12532601",
            'sku' => '123435238901301',
            'color' => 'negro',
            'trash' => 0
        ],[
            'id' => 25,
            'imei' => "123530123001",
            'sim' => "5325325",
            'equipment' => 1,
            'lost' => 0,
            'line' => null,
            'office_guide' => "12532601",
            'sku' => '123435238901301',
            'color' => 'negro',
            'trash' => 0
        ]
      ];
    \DB::table('stocks')->insert($stock);
    }
}
