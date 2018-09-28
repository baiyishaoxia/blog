<?php

namespace App\Http\Controllers\Home;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestController extends Controller
{
    //region   数据库读取速度测试        tang
    public function GetTestList()
    {
        $limit = 10000;
        $data = \DB::table('ruiec_users')
            ->leftJoin('ruiec_user_logs', 'ruiec_users.id', '=', 'ruiec_user_logs.user_id')
            ->orderBy("ruiec_user_logs.created_at","asc")->paginate($limit);
        $count = '当前第'.$data->currentPage().'页，每页'.$data->perPage().'条数据,'.'总共'.$data->total().'条数据。';
        return view('Test.demo',compact('data','count'));
     }
    //endregion
}
