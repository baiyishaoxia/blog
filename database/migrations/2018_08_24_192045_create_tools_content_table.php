<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateToolsContentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tools_content', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('list_id'); //分类id
            $table->string('call_index',255)->nullable(); //标识符
            $table->string('title',255);                  //标题
            $table->string('link',255)->nullable();       //链接
            $table->string('img',255)->nullable();        //图片
            $table->string('intro',255)->nullable();      //摘要
            $table->text('abstract')->nullable();                //简介
            $table->text('content')->nullable();                 //内容
            $table->integer('sort')->default(99);                //排序
            $table->integer('click')->default(0);                //浏览量
            $table->string('file_url',255)->nullable();  //文件url

            $table->boolean('is_top')->default(false);     //是否置顶
            $table->boolean('is_red')->default(false);     //是否推荐
            $table->boolean('is_hot')->default(false);     //是否热门
            $table->boolean('is_slide')->default(false);   //是否幻灯片

            $table->string('seo_title',255)->nullable(); //seo选项
            $table->string('seo_keywords',255)->nullable();
            $table->string('seo_description',255)->nullable();

            $table->softDeletes();                               //软删除
            $table->timestamps();                                //创建时间
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tools_content');
    }
}
