<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email');
            $table->string('paymentTerm');
            $table->string('address');
            $table->string('currancy');
            $table->integer('country');
            $table->integer('city');
            $table->string('contactPerson');
            $table->string('phoneNumber');
            $table->integer('user_id');
            $table->integer('visible');

            $table->index(['id' , 'email' , 'user_id' , 'visible']);

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
        Schema::dropIfExists('suppliers');
    }
}
