<?php

use Illuminate\Database\Seeder;

class AdminRoleNodeTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('admin_role_node')->delete();
        
        \DB::table('admin_role_node')->insert(array (
            0 => 
            array (
                'id' => 2,
                'admin_role_id' => 2,
                'admin_navigation_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 3,
                'admin_role_id' => 2,
                'admin_navigation_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}