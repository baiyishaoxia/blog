<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMobileOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobile_order', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('member_id')->comment('用户ID');
            $table->string('order_no',50)->comment('订单号');
            $table->double('total_price',10,2)->comment('总价格');
            $table->integer('status')->comment('状态');
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
        Schema::dropIfExists('mobile_order');
    }
}
