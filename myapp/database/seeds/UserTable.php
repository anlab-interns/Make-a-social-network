<?php

use App\User;
use Illuminate\Database\Seeder;

class UserTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        //
        Eloquent::unguard();
        User::create(array(
            'name' => 'quy',
            'email' => 'quy@gmail.com',
            'password' => Hash::make('123456789')
        ));
        User::create(array(
            'name' => 'hiep',
            'email' => 'hiep@gmail.com',
            'password' => Hash::make('123456789')
        ));
        User::create(array(
            'name' => 'quan',
            'email' => 'quan@gmail.com',
            'password' => Hash::make('123456789')
        ));
    }
}
