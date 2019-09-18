<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmsKeyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_key', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sms_id');
            $table->string('name')->unique();
            $table->string('key');
            $table->timestamps();
            //$table->foreign('sms_id')->references('id')->on('sms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sms_key');
    }
}
