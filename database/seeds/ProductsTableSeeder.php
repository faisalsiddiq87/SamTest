<?php

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 15; $i++) { 
	    	Product::create([
                'name' => 'Product ' . $i . ': ' . str_random(5),
                'price' => '220.10',
                'description' =>  str_random(40),
	            'created_by' => 1,
	            'updated_by' => 1
	        ]);
    	}
    }
}
