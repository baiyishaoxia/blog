<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(AdminTableSeeder::class);
        $this->call(FileTableSeeder::class);
        $this->call(FileKeyTableSeeder::class);
        $this->call(AdminNavigationTableSeeder::class);
        $this->call(AdminNavigationNodeTableSeeder::class);
        $this->call(AdminRoleTableSeeder::class);
        $this->call(AdminRoleNodeTableSeeder::class);
        $this->call(AdminRoleNodeRoutesTableSeeder::class);
    }
}
