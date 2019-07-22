<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesordersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salesorders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('line_id');
            $table->string('description');
            $table->integer('quantaty');
            $table->integer('unitPrice');
            $table->integer('taxes');
            $table->string('notes');
            $table->integer('user_id');
            $table->Integer('item_id');
            $table->integer('customer_id');
            $table->integer('adress_id');
            $table->integer('phone_id');
            $table->integer('paymentterm_id');
            $table->integer('totalQuantaty');
            $table->integer('totalPrice');
            $table->dateTime('arriveDate');
            $table->integer('user_id');
            $table->integer('visible');

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
        Schema::dropIfExists('salesorders');
    }
}
