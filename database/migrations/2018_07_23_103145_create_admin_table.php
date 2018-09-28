<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username',50);
            $table->string('password',255);
            $table->tinyInteger('is_lock')->default(0)->comment('是否锁定(1锁定0未锁定)');
            $table->integer('login_count')->default(0)->comment('登录次数');
            $table->timestamp('last_login')->default('0000-00-00 00:00:00')->comment('上次登录时间');
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
        Schema::dropIfExists('admin');
    }
}
