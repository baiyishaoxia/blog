<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    //首页
    public function getIndex()
    {
        return view('home.default.index');
    }
}
