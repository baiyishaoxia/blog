<?php

use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('admin')->delete();
        
        \DB::table('admin')->insert(array (
            0 => 
            array (
                'id' => 1,
                'admin_role_id' => 1,
                'username' => 'admin',
                'password' => Crypt::encrypt('admin'),
                'email' => '227@qq.com',
                'mobile' => '15826538517',
                'is_lock' => 0,
                'login_count' => 32,
                'last_login' => '2018-10-12 14:48:46',
                'created_at' => NULL,
                'updated_at' => '2018-10-12 20:08:39',
            ),
            1 => 
            array (
                'id' => 2,
                'admin_role_id' => 4,
                'username' => 'tang',
                'password' => Crypt::encrypt('123456'),
                'email' => NULL,
                'mobile' => '13926538518',
                'is_lock' => 0,
                'login_count' => 194,
                'last_login' => '2018-10-11 19:41:52',
                'created_at' => '2018-10-07 11:03:06',
                'updated_at' => '2018-10-11 19:41:52',
            ),
            2 => 
            array (
                'id' => 15,
                'admin_role_id' => 2,
                'username' => 'test',
                'password' => Crypt::encrypt('123456'),
                'email' => 'tzf2273465837@126.com',
                'mobile' => '13530928725',
                'is_lock' => 1,
                'login_count' => 0,
                'last_login' => NULL,
                'created_at' => '2018-10-08 21:57:51',
                'updated_at' => '2018-10-10 18:06:56',
            ),
            3 => 
            array (
                'id' => 16,
                'admin_role_id' => 4,
                'username' => '13530928725',
                'password' => Crypt::encrypt('123456'),
                'email' => '13530928725@qq.com',
                'mobile' => '13530928725',
                'is_lock' => 0,
                'login_count' => 0,
                'last_login' => NULL,
                'created_at' => '2018-10-10 14:16:48',
                'updated_at' => '2018-10-10 17:43:37',
            ),
            4 => 
            array (
                'id' => 17,
                'admin_role_id' => 2,
                'username' => '小六',
                'password' => Crypt::encrypt('123456'),
                'email' => '88677@qq.com',
                'mobile' => '13826538517',
                'is_lock' => 0,
                'login_count' => 2,
                'last_login' => NULL,
                'created_at' => '2018-10-12 17:02:59',
                'updated_at' => '2018-10-12 20:13:43',
            ),
        ));
        //重置自增长
        $id = \DB::table('admin')->max('id');
        $id= $id+1;
        \DB::statement("alter table blog_admin AUTO_INCREMENT = ".$id);
    }
}