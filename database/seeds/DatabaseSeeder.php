<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(StatesSeeder::class);
        $this->call(SubstatesSeeder::class);
        $this->call(CommuneRegionSeeder::class);
        $this->call(ClientsTableSeeder::class);
        $this->call(usersSeeder::class);
        $this->call(EquipamentsTableSeeder::class);
        $this->call(PlansTableSeeder::class);
        $this->call(SalesTableSeeder::class);
        $this->call(PromotionsTableSeeder::class);
        $this->call(StockTableSeeder::class);
        $this->call(LinesSeeder::class);
        //$this->call(ExcelTableSeeder::class);
        $this->call(EventsSeeder::class);
        $this->call(HistoriesTableSeeder::class);
    }
}
