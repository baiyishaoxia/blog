<?php

use Illuminate\Database\Seeder;

class SmsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('sms')->delete();
        
        \DB::table('sms')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => '云片',
                'sign' => '测试',
                'is_enable' => 1,
                'key' => 'YunPian',
                'created_at' => '2019-04-13 12:46:30',
                'updated_at' => '2019-04-13 12:46:30',
            ),
        ));
        
        
    }
}