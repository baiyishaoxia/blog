<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesClassTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images_class', function (Blueprint $table) {
            $table->increments('Id');
            $table->integer('Pid')->nullable();
            $table->string('Name',50)->nullable();
            $table->integer('Sort')->nullable();
            $table->string('Icon',50)->nullable();
            $table->string('IsDel',11)->nullable();
            $table->string('Intro',255)->nullable();
            $table->string('Time',20)->nullable();
            $table->string('SeoTitle',100)->nullable();
            $table->string('Keywords',255)->nullable();
            $table->string('Description',255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images_class');
    }
}
