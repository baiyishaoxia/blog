<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ToolsController extends Controller
{
    //region   工具类        tang
    public function getCreate()
    {
        return view('admin.tools.create');
    }
    //endregion
}
