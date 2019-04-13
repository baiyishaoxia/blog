<?php

use Illuminate\Database\Seeder;

class SmsKeyTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('sms_key')->delete();
        
        \DB::table('sms_key')->insert(array (
            0 => 
            array (
                'id' => 1,
                'sms_id' => 1,
                'name' => 'yunpian.apikey',
                'key' => '81e2d7ae56e5f6ccd66319c9de48195a',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'sms_id' => 1,
                'name' => 'YunPian.validtime',
                'key' => '300',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'sms_id' => 1,
                'name' => 'YunPian.minnumber',
                'key' => '10000',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'sms_id' => 1,
                'name' => 'YunPian.maxnumber',
                'key' => '99999',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'sms_id' => 1,
                'name' => 'YunPian.intervaltime',
                'key' => '60',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}