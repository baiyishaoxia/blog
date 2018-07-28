<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateToolsListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tools_list', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->nullable();
            $table->string('text',100)->nullable();
            $table->string('textarea',255)->nullable();
            $table->integer('sort')->default(99)->nullable();
            $table->integer('order')->default(99)->nullable();
            $table->boolean('is_sys')->default(false)->nullable();

            $table->string('file_version',10)->nullable();
            $table->string('file_system',10)->nullable();
            $table->string('file_path',255)->nullable();
            $table->string('file_log',255)->nullable();
            $table->boolean('is_top')->default(false);     //是否置顶
            $table->boolean('is_red')->default(false);     //是否推荐
            $table->boolean('is_hot')->default(false);     //是否热门
            $table->boolean('is_slide')->default(false);   //是否幻灯片
            $table->integer('redio')->nullable();
            $table->string('img',255)->nullable();
            $table->string('files',255)->nullable();
            $table->string('video',255)->nullable();

            $table->string('imgs',255)->nullable();

            $table->text('abstruct')->nullable();
            $table->text('content')->nullable();
            $table->text('discription')->nullable();

            $table->string('seo_title',255)->nullable();
            $table->string('seo_keywords',255)->nullable();
            $table->string('seo_description',255)->nullable();

            $table->softDeletes();                               //软删除
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
        Schema::dropIfExists('tools_list');
    }
}
