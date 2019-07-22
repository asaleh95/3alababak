<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOnhandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('onhands', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('item_id');
            // $table->bigInteger('warehouse_id');
            $table->bigInteger('locator_id');
            $table->bigInteger('primaryQuantity');
            $table->bigInteger('unitofmeasure_id');
            $table->bigInteger('pcsQuantity');
            $table->integer('visible');


            $table->index(['id' , 'locator_id' , 'item_id' , 'visible']);

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
        Schema::dropIfExists('onhands');
    }
}
