<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminNavigationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_navigation', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('parent_id')->nullable();         //父亲的ID
            $table->bigInteger('site_id')->nullable();           //所属站点的ID
            $table->bigInteger('site_channel_id')->nullable();        //所属频道的ID
            $table->string('title');                            //手机号码
            $table->string('ico')->nullable();                  //ICO图标
            $table->integer('sort')->default('99');             //排序，数字越小越靠前
            $table->boolean('is_show')->default(false);         //是否锁定,默认不锁定
            $table->boolean('is_sys')->default(false);
            $table->timestamps();
            //$table->foreign('parent_id')->references('id')->on('admin_navigation');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_navigation');
    }
}
