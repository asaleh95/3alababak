<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributeItemValueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribute_item_value', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('item_id');
            $table->integer('attribute1_id');
            $table->integer('value1_id');
            $table->integer('attribute2_id');
            $table->integer('value2_id');
            $table->integer('attribute3_id');
            $table->integer('value3_id');
            $table->integer('attribute4_id');
            $table->integer('value4_id');
            $table->integer('attribute5_id');
            $table->integer('value5_id');
            $table->integer('attribute6_id');
            $table->integer('value6_id');
            $table->integer('attribute7_id');
            $table->integer('value7_id');
            $table->integer('attribute8_id');
            $table->integer('value8_id');
            $table->integer('attribute9_id');
            $table->integer('value9_id');
            $table->integer('attribute10_id');
            $table->integer('value10_id');

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
        Schema::dropIfExists('attribute_item_value');
    }
}
