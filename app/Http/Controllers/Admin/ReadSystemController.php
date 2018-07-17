<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReadSystemController extends Controller
{
    public function getElement()
    {
        return view('admin.read_system.element');
    }

    public function getList(Request $request)
    {
        if($request->post()){
            return back()->withErrors('此页面是模板,请勿非法操作!');
        }
        return view('admin.read_system.list');
    }

    public function getTab()
    {
        return view('admin.read_system.tab');
    }
}
