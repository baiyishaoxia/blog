<?php

namespace App\Http\Controllers\Background;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ToolsController extends Controller
{
    /**
     * GET 上传附件页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author tang
     */
    public function getFile(){
        return view('background.tools.file');
    }
}
