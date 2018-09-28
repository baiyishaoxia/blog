<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLangNationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lang_nations', function (Blueprint $table) {
            $table->string('id',32);
            $table->string('image_url')->comment('国家图片');
            $table->string('title')->comment('国家');
            $table->integer('sort')->default(99)->comment('排序');
            $table->boolean('is_default')->default(false)->comment('是否默认');
            $table->boolean('is_open')->default(false)->comment('是否启用');
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
        Schema::dropIfExists('lang_nations');
    }
}
