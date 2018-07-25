<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category', function (Blueprint $table) {
            $table->increments('cate_id');
            $table->string('cate_name',20)->comment('分类名称');
            $table->string('cate_title',255)->nullable()->comment('分类说明');
            $table->string('cate_keyword',255)->nullable()->comment('关键字');
            $table->string('cate_discription',255)->nullable()->comment('描述');
            $table->integer('cate_view')->nullable()->comment('查看次数');
            $table->integer('cate_order')->default(0)->comment('排序');
            $table->integer('cate_pid')->nullable()->comment('父级分类');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category');
    }
}
