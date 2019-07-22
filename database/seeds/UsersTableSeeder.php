<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // App\User::create(["name"=>'AM',"email" =>'Am@3alababak.com','password'=>bcrypt('12345678')]);
        // $users = factory(App\User::class, 10)->create();
        // $role = App\Role::find(1);
        // $users = App\User::all();
        $users = App\User::create(["name"=>'menna',"email" =>'mennna','password'=>bcrypt('12345678')]);
        // $role->users()->saveMany($users);

    }
}
