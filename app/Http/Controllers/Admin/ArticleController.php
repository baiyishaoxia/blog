<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Article;
use App\Http\Model\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rules\In;
use Symfony\Component\HttpFoundation\IpUtils;

class ArticleController extends CommonController
{
    //admin.article(get) 全部文章列表
    public function index()
    {
        $perpage = 6;
        $data = Article::orderBy('art_id','desc')->paginate($perpage);
        $count = '当前第'.$data->currentPage().'页，每页'.$data->perPage().'条数据,'.'总共'.$data->total().'条数据。';
        return view('admin.article.index',compact('data','count'));
    }

    //admin.article.create(get) 添加文章
    public function create()
    {
       $data = Category::moreTree();
       return view('admin.article.add',compact('data'));
    }

    //admin.article.store(post)
    public function store()
    {
       $input = Input::except('_token');
       if(!$input['art_thumb']){
           $input['art_thumb'] = 'uploads/default.jpg';
       }
       $input['art_time'] = time();
       $rules = [
         'art_title' =>'required',
         'art_author'=>'required',
         'art_content'=>'required',
       ];
       $message = [
         'art_title.required' =>'文章标题不能为空!',
         'art_author.required' =>'文章作者不能为空!',
         'art_content.required' =>'文章内容不能为空!',
       ];
       $validator = \Validator::make($input,$rules,$message);
       if($validator->passes()){
           $re = Article::create($input);
           if($re){
               return redirect('admin/article');
           }else{
               return back()->withErrors('数据填充失败，请稍后重试！');
           }
       }else{
           return back()->withErrors($validator);
       }
    }

    //admin.article.{article}.edit(get) 修改
    public function edit($art_id)
    {
        $filed = Article::select('*')->find($art_id);
        $data = Category::moreTree($filed->cate_id);
        return view('admin.article.edit',compact('data','filed'));
    }
    //admin.article.{article}(put)  处理修改
    public function update($art_id)
    {
       $input = Input::except('_token','_method');
       $rules = [
            'art_title' =>'required',
            'art_author'=>'required',
            'art_content'=>'required',
        ];
       $message = [
            'art_title.required' =>'文章标题不能为空!',
            'art_author.required' =>'文章作者不能为空!',
            'art_content.required' =>'文章内容不能为空!',
        ];
       $validator = \Validator::make($input,$rules,$message);
       if($validator->passes()) {
           $re = Article::where('art_id',$art_id)->update($input);
           if ($re) {
               return redirect('admin/article');
           } else {
               return back()->withErrors('数据更改失败！');
           }
       }return back()->withErrors($validator);
    }
    //admin.article.{article}(delete) 删除单个显示
    public function destroy($art_id)
    {
        $re = Article::where('art_id',$art_id)->delete();
        if($re){
            $data = [
                'status'=>0,
                'msg'  =>'恭喜,文章删除成功!',
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'  =>'抱歉,文章删除失败,请稍后重试!',
            ];
        }
        return $data;
    }


}
