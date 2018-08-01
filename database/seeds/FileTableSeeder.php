<?php

use Illuminate\Database\Seeder;

class FileTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('file')->delete();
        
        \DB::table('file')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => '文件',
                'type' => 'file',
                'is_enable' => '1',
                'key' => 'local',
                'created_at' => '2018-03-05 10:26:20',
                'updated_at' => '2018-07-17 10:57:32',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => '图片',
                'type' => 'image',
                'is_enable' => '1',
                'key' => 'local',
                'created_at' => '2018-03-05 10:26:20',
                'updated_at' => '2018-07-17 11:01:01',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => '视频',
                'type' => 'video',
                'is_enable' => '1',
                'key' => 'local',
                'created_at' => '2018-03-05 10:26:20',
                'updated_at' => '2018-07-17 11:01:04',
            ),
        ));
        $id = \DB::table('file')->max('id');
        $id= $id+1;
        \DB::statement("alter table blog_file AUTO_INCREMENT = ".$id);
        
        
    }
}