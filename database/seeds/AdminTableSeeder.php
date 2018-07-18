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
                'user_id' => 1,
                'user_name' => 'admin',
                'user_pass' => Crypt::encrypt('admin'),
            ),
        ));
        
        
    }
}