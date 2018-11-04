<?php

use Illuminate\Database\Seeder;

class EmailTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('email')->delete();
        
        \DB::table('email')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => '126 Email',
                'is_enable' => 1,
                'key' => 'smtp',
                'created_at' => '2018-10-19 18:52:00',
                'updated_at' => '2018-10-19 18:52:00',
            ),
        ));
        //重置自增长
        $id = \DB::table('email')->max('id');
        $id= $id+1;
        \DB::statement("alter table blog_email AUTO_INCREMENT = ".$id);
        
    }
}