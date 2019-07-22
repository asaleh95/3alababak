<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('address');
            $table->integer('country');
            $table->integer('city');
            $table->string('phoneNumber');
            $table->morphs('addressable');
            $table->integer('visible');
            
            $table->timestamps();

            $table->index(['id' , 'visible' , 'addressable_id' , 'addressable_type']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
}
