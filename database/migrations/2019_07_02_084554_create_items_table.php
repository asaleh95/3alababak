<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->unique();
            $table->string('name');
            $table->longText('description');
            $table->bigInteger('subcategory_id');
            $table->integer('vat');
            $table->dateTime('expiryDate');
            $table->string('statusLookup');
            $table->longText('image');
            $table->bigInteger('unitofmeasure_id');
            $table->bigInteger('piecesConv');
            $table->integer('souqSkuNumber')->unique();
            $table->integer('noonSkuNumber')->unique();
            $table->integer('planned');
            $table->integer('purchaseorder_id');

            $table->integer('user_id');
            // $table->integer('customer_id');
            $table->integer('visible');

            $table->index(['id' , 'code' , 'subcategory_id' , 'user_id' , 'visible']);

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
        Schema::dropIfExists('items');
    }
}
