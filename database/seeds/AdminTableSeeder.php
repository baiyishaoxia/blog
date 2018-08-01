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
                'username' => 'admin',
                'password' => Crypt::encrypt('admin'),
            ),
        ));
        //重置自增长
        $id = \DB::table('admin')->max('id');
        $id= $id+1;
        \DB::statement("alter table blog_admin AUTO_INCREMENT = ".$id);
        
    }
}