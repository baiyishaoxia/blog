<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminRoleNodeRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_role_node_routes', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('admin_role_id');                                                 //外键
            $table->bigInteger('admin_navigation_node_id');                                      //外键
           // $table->foreign('admin_role_id')->references('id')->on('admin_role');
            //$table->foreign('admin_navigation_node_id')->references('id')->on('admin_navigation_node');
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
        Schema::dropIfExists('admin_role_node_routes');
    }
}
