<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Article;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AppController extends Controller
{
    //region   检测users表用户是否存在        tang
    public function postCheckUser(Request $request)
    {
       $username= $request->name;
       $data = User::where(['name'=>$username])->select('id','name','email')->first();
       if($data){
           return json_encode(['status'=>200,'msg'=>'用户存在','data'=>$data]);
       }else{
           return json_encode(['status'=>0,'msg'=>'用户不存在','data'=>'']);
       }
    }
    //endregion

    //region   获取文章(参数：page页码，limit条数)        tang
    public function getArticle(Request $request)
    {
        $page = $request->get('page');
        $limit = $request->get('limit');
        $data = Article::orderBy('art_id','desc')->select('art_id','art_title','created_at')->offset(($page-1)*$limit)->limit($limit)->get();
        if(count($data)==0){
            return json_encode(['status'=>200,'mgs'=>'获取成功','data'=>'暂无数据']);
        }
        return json_encode(['status'=>200,'mgs'=>'获取成功','data'=>$data]);
    }
    //endregion
}
