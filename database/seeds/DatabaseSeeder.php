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
        $this->call(AdminTableSeeder::class);   //管理员初始化
        $this->call(FileTableSeeder::class);    //文件类型初始化
        $this->call(FileKeyTableSeeder::class); //文件参数配置初始化
        $this->call(AdminNavigationTableSeeder::class);    //权限初始化
        $this->call(AdminNavigationNodeTableSeeder::class);//权限路由初始化
        $this->call(AdminRoleTableSeeder::class);     //角色初始化
        $this->call(AdminRoleNodeTableSeeder::class);//角色权限初始化
        $this->call(AdminRoleNodeRoutesTableSeeder::class);//权限节点路由初始化
        $this->call(EmailTableSeeder::class);    //Email服务器初始化
        $this->call(EmailKeyTableSeeder::class); //Email服务器配置初始化
        $this->call(SmsTableSeeder::class);      //短信服务商
        $this->call(SmsKeyTableSeeder::class);   //短信配置
    }
}
