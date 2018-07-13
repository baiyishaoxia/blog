<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images_content', function (Blueprint $table) {
            $table->increments('Id');
            $table->integer('ImgClass_Id');
            $table->integer('AnnexId')->nullable();
            $table->string('Icon',55);
            $table->integer('Width')->nullable();
            $table->integer('Height')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images_content');
    }
}
