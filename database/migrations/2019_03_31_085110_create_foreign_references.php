<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForeignReferences extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function(Blueprint $table) {
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');     
        });
    
        Schema::table('orders', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('payments', function(Blueprint $table) {
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('order_id')->references('id')->on('orders');
        });
    
        Schema::table('orders_products', function(Blueprint $table) {
            $table->foreign('order_id')->references('id')->on('orders');
        });
    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
