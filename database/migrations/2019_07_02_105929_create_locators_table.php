<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locators', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->unique();
            $table->longText('description');
            $table->bigInteger('warehouse_id');
            $table->integer('user_id');
            $table->integer('visible');

            $table->index(['id' , 'code' , 'user_id' , 'warehouse_id' , 'visible']);

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
        Schema::dropIfExists('locators');
    }
}
