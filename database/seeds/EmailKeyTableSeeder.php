<?php

use Illuminate\Database\Seeder;

class EmailKeyTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('email_key')->delete();
        
        \DB::table('email_key')->insert(array (
            0 => 
            array (
                'id' => 1,
                'email_id' => 1,
                'name' => 'smtp.host.1',
                'key' => 'smtp.126.com',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'email_id' => 1,
                'name' => 'smtp.is_ssl.1',
                'key' => 'ssl',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'email_id' => 1,
                'name' => 'smtp.port.1',
                'key' => '465',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'email_id' => 1,
                'name' => 'smtp.from.1',
                'key' => '白衣少侠',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'email_id' => 1,
                'name' => 'smtp.username.1',
                'key' => 'tzf2273465837@126.com',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'email_id' => 1,
                'name' => 'smtp.password.1',
                'key' => '123456',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'email_id' => 1,
                'name' => 'smtp.nick.1',
                'key' => 'by 白衣少侠',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        //重置自增长
        $id = \DB::table('email_key')->max('id');
        $id= $id+1;
        \DB::statement("alter table blog_email_key AUTO_INCREMENT = ".$id);
    }
}