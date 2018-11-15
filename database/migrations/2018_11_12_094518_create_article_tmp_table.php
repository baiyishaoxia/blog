<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleTmpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_tmp', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');              //用户id
            $table->string('title')->nullable();     //活动名称
            $table->string('tmp_title')->nullable();//活动管理员
            $table->string('logo');                  //活动logo
            $table->integer('article_template')->nullable();//活动模板
            $table->text('tmp_detail')->nullable();    //活动详情
            $table->integer('click')->default(0);      //浏览量
            $table->integer('number')->default(0);        //限制人数
            $table->integer('sign_up_num')->default(0);//参与人数
            $table->integer('status')->default(0);     //(0待审核 1通过 2未通过)
            $table->string('comment')->nullable();     //审核评论
            $table->timestamp('start_time')->nullable();//开始时间
            $table->timestamp('end_time')->nullable();  //结束时间
            $table->boolean('is_del')->default(false); //是否删除
            $table->softDeletes();                               //软删除
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
        });

        //扩展字段
        Schema::create('article_tmp_extra_field', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');        //用户id
            $table->integer('article_tmp_id');//活动id
            $table->string('title');           //字段名称
            $table->boolean('is_required')->default(false);//是否必填
            $table->string('field_type');     //报名项字段类型
            $table->string('child')->nullable();//字段选项值（针对单选、多选、下拉）
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('article_tmp_id')->references('id')->on('article_tmp');
        });

        //扩展字段数据
        Schema::create('article_tmp_extra_field_data', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');        //用户id
            $table->integer('article_tmp_id');//活动id
            $table->integer('article_tmp_extra_field_id');//活动的额外字段id
            $table->text('value')->nullable();//字段值
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('user');
            $table->foreign('article_tmp_id')->references('id')->on('article_tmp');
            $table->foreign('article_tmp_extra_field_id')->references('id')->on('article_tmp_extra_field');
        });
        //上传logo
        Schema::create('article_tmp_images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('title')->nullable();
            $table->string('file_url');//文件地址
            $table->string('file_size');//文件大小
            $table->string('file_name');//上传的文件原名称
            $table->string('file_suffix');//文件格式后缀
            $table->string('file_now_name')->nullable();//上传文件后的文件名
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
        Schema::dropIfExists('article_tmp');
    }
}
