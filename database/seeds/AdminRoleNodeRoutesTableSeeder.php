<?php

use Illuminate\Database\Seeder;

class AdminRoleNodeRoutesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('admin_role_node_routes')->delete();
        
        \DB::table('admin_role_node_routes')->insert(array (
            0 => 
            array (
                'id' => 4,
                'admin_role_id' => 2,
                'admin_navigation_node_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 5,
                'admin_role_id' => 2,
                'admin_navigation_node_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 6,
                'admin_role_id' => 2,
                'admin_navigation_node_id' => 3,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 7,
                'admin_role_id' => 2,
                'admin_navigation_node_id' => 5,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 8,
                'admin_role_id' => 2,
                'admin_navigation_node_id' => 6,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 9,
                'admin_role_id' => 2,
                'admin_navigation_node_id' => 7,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}