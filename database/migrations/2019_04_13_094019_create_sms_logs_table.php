<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmsLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_log', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sms_id');                  //发送
            $table->string('prefixe');              //国际权限区域前缀
            $table->string('mobile');               //手机号码
            $table->string('content');              //短信内容
            $table->timestamps();
            //$table->foreign('sms_id')->references('id')->on('sms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sms_logs');
    }
}
