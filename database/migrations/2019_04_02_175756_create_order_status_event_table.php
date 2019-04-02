<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderStatusEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::unprepared('SET GLOBAL event_scheduler = ON;
        CREATE EVENT confirm_Order
        ON SCHEDULE EVERY 15 SECOND
        DO
           UPDATE orders SET STATUS = 4 where status = 3;');
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
