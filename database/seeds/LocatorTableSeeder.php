<?php

use Illuminate\Database\Seeder;

class LocatorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $loctors = factory(App\Locator::class, 20)->create();
        $warehouse = App\Warehouse::find(1);
        $warehouse_ids = $warehouse->pluck('id');
        $warehouse->locators()->save($warehouse_ids);
    }
}
