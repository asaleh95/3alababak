<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseordersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchaseorders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('line_id');
            $table->string('description');
            $table->integer('quantaty');
            $table->integer('unitPrice');
            $table->integer('taxes');
            $table->string('notes');
            $table->integer('user_id');
            $table->integer('supplier_id');
            $table->Integer('item_id');
            $table->Integer('paymentterm_id');
            $table->Integer('totalPrice');
            $table->Integer('totalQuantaty');
            $table->Integer('shippingCost');

            // $table->integer('purchaseorderheader_id');
            $table->integer('visible');

            $table->index(['id' , 'user_id' , 'item_id' , 'visible']);

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
        Schema::dropIfExists('purchaseorders');
    }
}
