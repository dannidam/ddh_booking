<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FoodbookingBookings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('foodbooking_bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('shop_id');
            $table->string('email');
            $table->string('reservation_id')->unique();
            $table->string('seats');
            $table->string('timespot');
            $table->string('drink');
            $table->string('food');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('foodbooking_bookings');
    }
}
