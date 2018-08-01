<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMobilePhoneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobile_phone', function (Blueprint $table) {
            $table->increments('id');
            $table->string('phone',11)->comment('手机号');
            $table->integer('code')->comment('验证码');
            $table->timestamp('deadline')->comment('过期时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mobile_phone');
    }
}
