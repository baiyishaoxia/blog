<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Model\User;
use Illuminate\Support\Facades\Input;

class IndexController extends Controller
{
    //admin.category(get)  列表
    public function index()
    {
      echo 'index';
    }

    //admin.category.create(get) 添加
    public function create()
    {

    }

    //admin.category(post) 处理添加
    public function store()
    {

    }

    //admin.category.show(get) 单个显示
    public function show()
    {

    }
    //admin.category.{category}(delete) 删除单个显示
    public function destroy()
    {

    }

    //admin.category.{category}.edit (get) 修改
    public function edit()
    {

    }

    //admin.category.{category}(put)  处理修改
    public function update()
    {

    }

}
