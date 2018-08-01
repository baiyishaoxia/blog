<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMobileMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobile_member', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nickname',20)->nullable()->comment('昵称');
            $table->string('phone',20)->comment('手机号');
            $table->string('email',50)->unique()->comment('邮箱');
            $table->string('password',255)->comment('密码');
            $table->integer('active')->default(0)->comment('邮箱激活状态');
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
        Schema::dropIfExists('mobile_member');
    }
}
