<?php

use Illuminate\Database\Seeder;

class FileKeyTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('file_key')->delete();
        
        \DB::table('file_key')->insert(array (
            0 => 
            array (
                'id' => 56,
                'file_id' => 2,
                'name' => 'size.2',
                'key' => '100',
                'created_at' => '2018-03-05 10:26:20',
                'updated_at' => '2018-03-05 10:26:20',
            ),
            1 => 
            array (
                'id' => 57,
                'file_id' => 2,
                'name' => 'type.2',
                'key' => 'jpg,png',
                'created_at' => '2018-03-05 10:26:20',
                'updated_at' => '2018-03-05 10:26:20',
            ),
            2 => 
            array (
                'id' => 58,
                'file_id' => 2,
                'name' => 'savetype.2',
                'key' => 'ymd',
                'created_at' => '2018-03-05 10:26:20',
                'updated_at' => '2018-03-05 10:26:20',
            ),
            3 => 
            array (
                'id' => 62,
                'file_id' => 1,
                'name' => 'size.1',
                'key' => '100',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 63,
                'file_id' => 1,
                'name' => 'type.1',
                'key' => 'rar,zip,pdf,jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 64,
                'file_id' => 1,
                'name' => 'savetype.1',
                'key' => 'ymd',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 65,
                'file_id' => 3,
                'name' => 'size.3',
                'key' => '100',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 66,
                'file_id' => 3,
                'name' => 'type.3',
                'key' => 'mp4,flv',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 67,
                'file_id' => 3,
                'name' => 'savetype.3',
                'key' => 'ymd',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}