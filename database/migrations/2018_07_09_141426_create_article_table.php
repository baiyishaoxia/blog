<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article', function (Blueprint $table) {
            $table->increments('art_id');
            $table->string('art_title',100);           //标题
            $table->string('art_tag',100)->nullable(); //标签可为空
            $table->string('art_discription',255);    //描述
            $table->string('art_thumb',255);           //缩略图
            $table->text('art_content');                      //内容
            $table->string('art_author',11);          //作者
            $table->integer('art_view')->default(0);    //查看次数 默认0
            $table->integer('art_time');    //时间戳
            $table->integer('art_order');   //排序
            $table->integer('cate_id');     //分类id

            $table->softDeletes(); //软删除
            $table->timestamps();  //创建时间 更新时间
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article');
    }
}
