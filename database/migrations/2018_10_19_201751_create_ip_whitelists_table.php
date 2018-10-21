<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIpWhitelistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ip_whitelists', function (Blueprint $table) {
            $table->increments('id');
            $table->ipAddress('start_ip');          //开始Ip段
            $table->ipAddress('end_ip');            //结束Ip段
            $table->string('type');                 //background后台应用，home前台应用
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
        Schema::dropIfExists('ip_whitelists');
    }
}
