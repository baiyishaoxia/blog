<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailKeyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_key', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('email_id');
            $table->string('name')->unique();
            $table->string('key');
            $table->timestamps();
            //$table->foreign('email_id')->references('id')->on('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email_key');
    }
}
