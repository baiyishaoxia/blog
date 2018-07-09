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
    public function index(Request $request)
    {
        $perpage = 8;
        $data = Article::orderBy('art_order','asc')->orderBy('art_id','desc');
        if($request->get('cate_id')){
            $data = $data->whereIn('cate_id', Category::where('cate_id',$request->get('cate_id'))->pluck('cate_id')->toArray())
                ->orWhereIn('cate_id', Category::where('cate_pid',$request->get('cate_id'))->pluck('cate_id')->toArray());
        }
        if($request->get('keywords')){
            $data = $data->where('art_title', 'like','%'.$request->get('keywords').'%');
        }
        $data = $data->paginate($perpage);
        $count = '当前第'.$data->currentPage().'页，每页'.$data->perPage().'条数据,'.'总共'.$data->total().'条数据。';

        $type = 'soft';
        return view('admin.article.index',compact('data','count','type'));
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
       $input = Input::except('_token','file_upload');
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
               return back()->withInput()->withErrors('数据填充失败，请稍后重试！');
           }
       }else{
           return back()->withInput()->withErrors($validator);
       }
    }

    //admin.article.{article}.edit(get) 修改
    public function edit($art_id)
    {
        $filed = Article::select('*')->find($art_id);
        $data = Category::moreTree($filed['cate_id']);
        return view('admin.article.edit',compact('data','filed'));
    }
    //admin.article.{article}(put)  处理修改
    public function update($art_id)
    {
       $input = Input::except('_token','_method','file_upload');
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

    //region   保存        tang
    public function postSave()
    {
        $input = Input::all();
        foreach ($input['data'] as $id => $data){
            $content_data = Article::find($id);
            $content_data->art_order = $data['sort'];
            $content_data->save();
        }
        return redirect('admin/article')->withErrors('保存成功');
    }
    //endregion

    //region   移动到回收站(软删除)        tang
    public function postSoftDel(Request $request)
    {
        try {
            $input = $request->all();
            Article::destroy($input['id']);
            return redirect(\URL::action('admin/article'))->withSuccess("删除成功");
        }catch (\Exception $e){
            return back()->withErrors("操作异常");
        }
    }
    //endregion

    //region   回收站列表        tang
    public function getRecycleList(Request $request)
    {
        $data = Article::onlyTrashed()->orderBy('art_id','desc');
        if($request->get('cate_id')){
            $data = $data->whereIn('cate_id', Category::where('cate_id',$request->get('cate_id'))->pluck('cate_id')->toArray())
                ->orWhereIn('cate_id', Category::where('cate_pid',$request->get('cate_id'))->pluck('cate_id')->toArray());
        }
        if($request->get('keywords')){
            $data = $data->where('art_title', 'like','%'.$request->get('keywords').'%');
        }
        $perpage = 8;
        $data = $data->paginate($perpage);
        $count = '当前第'.$data->currentPage().'页，每页'.$data->perPage().'条数据,'.'总共'.$data->total().'条数据。';
        $type = 'del';
        return view('admin.article.index',compact('data','count','type'));
    }
    //endregion

    //region   还原        tang
    public function postRestore(Request $request)
    {
        $ids = $request->get('id');
        if($ids){
            Article::withTrashed()->whereIn('art_id',$ids)->restore();
            return redirect(\URL::action('Admin\ArticleController@getRecycleList'))->withErrors('还原成功');
        }else{
            return back()->withErrors('还原失败,请选择需要还原的数据');
        }
    }
    //endregion

    //region   彻底删除        tang
    public function postDel(Request $request)
    {
        Article::whereIn('art_id',$request->get('id'))->forceDelete();
        return redirect(\URL::action('Admin\ArticleController@getRecycleList'))->withSuccess("删除成功");
    }
    //endregion


}
