<?php

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 3; $i++) { 
	    	User::create([
                'first_name' => str_random(8),
                'last_name' => str_random(8),
	            'email' => 'faisal.siddiq87+user0' . $i . '@gmail.com',
	            'password' => app('hash')->make('123456')
	        ]);
    	}
    }
}