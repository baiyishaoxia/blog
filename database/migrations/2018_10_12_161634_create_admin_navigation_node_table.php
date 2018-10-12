<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminNavigationNodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_navigation_node', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('admin_navigation_id')->nullable();                           //父亲的ID
            $table->string('route_action');                                       //当前访问的ACTION名称
            $table->string('parameter')->nullable();                                       //JSON格式参数
            $table->string('title');                          //控制器路由名称
            $table->integer('sort')->default('99');                  //排序，数字越小越靠前
            $table->timestamps();
            //$table->foreign('admin_navigation_id')->references('id')->on('admin_navigation');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_navigation_node');
    }
}
