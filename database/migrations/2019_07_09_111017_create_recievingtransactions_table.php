<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecievingtransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recievingtransactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('item_id');
            $table->bigInteger('warehouse_id');
            $table->bigInteger('locator_id');
            // $table->bigInteger('unitofmeasure_id');
            $table->bigInteger('primaryQuantity');
            $table->bigInteger('partialQuantity');
            // $table->string('recieving_source');
            // $table->bigInteger('recievingsource_id');
            $table->integer('user_id');
            $table->integer('visible');


            $table->index(['item_id' , 'user_id' , 'visible' , 'warehouse_id']);
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
        Schema::dropIfExists('recievingtransactions');
    }
}
