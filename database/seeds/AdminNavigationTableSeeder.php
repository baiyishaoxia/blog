<?php

use Illuminate\Database\Seeder;

class AdminNavigationTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('admin_navigation')->delete();
        
        \DB::table('admin_navigation')->insert(array (
            0 => 
            array (
                'id' => 1,
                'parent_id' => NULL,
                'site_id' => NULL,
                'site_channel_id' => NULL,
                'title' => '首页',
                'ico' => NULL,
                'sort' => 99,
                'is_show' => 1,
                'is_sys' => 1,
                'created_at' => '2018-10-12 17:52:30',
                'updated_at' => '2018-10-12 20:09:50',
            ),
            1 => 
            array (
                'id' => 2,
                'parent_id' => NULL,
                'site_id' => NULL,
                'site_channel_id' => NULL,
                'title' => '分类列表',
                'ico' => NULL,
                'sort' => 99,
                'is_show' => 1,
                'is_sys' => 1,
                'created_at' => '2018-10-12 20:12:22',
                'updated_at' => '2018-10-12 20:13:10',
            ),
        ));
        
        
    }
}