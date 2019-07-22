<?php

use Illuminate\Database\Seeder;

class SupplierTabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $suppliers= factory(App\Supplier::class, 12)->create();
        $user = App\User::find(1);
        $supp_ids = $suppliers->pluck('id');
        $user->suppliers()->attach($supp_ids);
    }
}
