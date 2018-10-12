<?php

use Illuminate\Database\Seeder;

class AdminNavigationNodeTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('admin_navigation_node')->delete();
        
        \DB::table('admin_navigation_node')->insert(array (
            0 => 
            array (
                'id' => 1,
                'admin_navigation_id' => 1,
                'route_action' => 'Admin\\IndexController@index',
                'parameter' => NULL,
                'title' => 'index',
                'sort' => 99,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'admin_navigation_id' => 1,
                'route_action' => 'Admin\\IndexController@info',
                'parameter' => NULL,
                'title' => 'info',
                'sort' => 99,
                'created_at' => '2018-10-12 17:53:50',
                'updated_at' => '2018-10-12 17:53:50',
            ),
            2 => 
            array (
                'id' => 3,
                'admin_navigation_id' => 1,
                'route_action' => 'Admin\\IndexController@pass',
                'parameter' => NULL,
                'title' => '修改密码',
                'sort' => 99,
                'created_at' => '2018-10-12 17:53:50',
                'updated_at' => '2018-10-12 20:09:50',
            ),
            3 => 
            array (
                'id' => 4,
                'admin_navigation_id' => 1,
                'route_action' => 'Admin\\LoginController@quit',
                'parameter' => NULL,
                'title' => '退出',
                'sort' => 99,
                'created_at' => '2018-10-12 20:09:50',
                'updated_at' => '2018-10-12 20:09:50',
            ),
            4 => 
            array (
                'id' => 5,
                'admin_navigation_id' => 2,
                'route_action' => 'Admin\\CategoryController@index',
                'parameter' => NULL,
                'title' => '列表',
                'sort' => 99,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'admin_navigation_id' => 2,
                'route_action' => 'Admin\\CategoryController@create',
                'parameter' => NULL,
                'title' => '新增',
                'sort' => 99,
                'created_at' => '2018-10-12 20:13:10',
                'updated_at' => '2018-10-12 20:13:10',
            ),
            6 => 
            array (
                'id' => 7,
                'admin_navigation_id' => 2,
                'route_action' => 'Admin\\CategoryController@store',
                'parameter' => NULL,
                'title' => '添加',
                'sort' => 99,
                'created_at' => '2018-10-12 20:13:10',
                'updated_at' => '2018-10-12 20:13:10',
            ),
        ));
        
        
    }
}