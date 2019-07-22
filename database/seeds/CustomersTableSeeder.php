<?php

use Illuminate\Database\Seeder;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // $customers= factory(App\Customer::class, 22)->create();
        // $user = App\User::find(1);
        // $cust_ids = $customers->pluck('id');
        // $user->customers()->attach($cust_ids);

        // $address1 = App\Address::create(["address"=> "kafr abdo" , "country"=> 7 , "city"=> 129]);
        // $address2 = App\Address::create(["address"=> "roshdy" , "country"=> 7 , "city"=> 129]);

        // $phone1 = App\Phonenumber::create(["phoneNumber"=> "01201145433"]);
        // $phone2 = App\Phonenumber::create(["phoneNumber"=> "01113094733"]);

        $customers = App\Customer::whereBetween('id', [36,56])->get();

        foreach ($customers as $customer) {
            # code...
            $address1 = App\Address::create(["address"=> "kafr abdo" , "country"=> 7 , "city"=> 129]);
        $address2 = App\Address::create(["address"=> "roshdy" , "country"=> 7 , "city"=> 129]);

        $phone1 = App\Phonenumber::create(["phoneNumber"=> "01201145433"]);
        $phone2 = App\Phonenumber::create(["phoneNumber"=> "01113094733"]);

            $customer->adresses()->save($address1);
            $customer->adresses()->save($address2);
            $customer->adresses()->save($phone1);
            $customer->adresses()->save($phone2);
        }

    }
}
