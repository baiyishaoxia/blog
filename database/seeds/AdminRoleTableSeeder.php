<?php

use Illuminate\Database\Seeder;

class AdminRoleTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('admin_role')->delete();
        
        \DB::table('admin_role')->insert(array (
            0 => 
            array (
                'id' => 1,
                'role_name' => '超级管理员',
                'is_super' => 1,
                'is_sys' => 0,
                'created_at' => '2018-10-08 17:53:44',
                'updated_at' => '2018-10-08 17:53:44',
            ),
            1 => 
            array (
                'id' => 2,
                'role_name' => '测试人员',
                'is_super' => 0,
                'is_sys' => 1,
                'created_at' => '2018-10-08 17:58:48',
                'updated_at' => '2018-10-12 20:13:22',
            ),
            2 => 
            array (
                'id' => 3,
                'role_name' => '运营人员',
                'is_super' => 0,
                'is_sys' => 0,
                'created_at' => '2018-10-08 18:02:53',
                'updated_at' => '2018-10-10 16:45:00',
            ),
            3 => 
            array (
                'id' => 4,
                'role_name' => '审核人员',
                'is_super' => 0,
                'is_sys' => 0,
                'created_at' => '2018-10-09 16:13:06',
                'updated_at' => '2018-10-09 17:23:33',
            ),
        ));
        
        
    }
}