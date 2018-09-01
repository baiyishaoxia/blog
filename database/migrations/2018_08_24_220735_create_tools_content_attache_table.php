<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateToolsContentAttacheTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tools_content_attache', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('content_id');
            $table->string('filename',255);
            $table->string('filepath',255);
            $table->string('filesize',255);
            $table->integer('point')->comment('积分');
            $table->integer('down_count')->default(0)->comment('下载次数');
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
        Schema::dropIfExists('tools_content_attache');
    }
}
