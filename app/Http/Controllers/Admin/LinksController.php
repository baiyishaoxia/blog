<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Links;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\URL;

class LinksController extends CommonController
{
    //admin.link (get)  列表
    public function index()
    {
        $data = Links::where('link_isdel',0)->orderBy('link_order','desc')->paginate(10);
        $count = '当前第'.$data->currentPage().'页，每页'.$data->perPage().'条数据,'.'总共'.$data->total().'条数据。';
        return view('admin.links.index',compact('data','count'));
    }
    //admin.link.create(get) 添加
    public function create()
    {
      return view('admin.links.add');
    }
    //admin.link(post) 处理添加
    public function store(Request $request)
    {
        $input = $request->all();
        $link = new Links();
        $link->link_name = $input['link_name'];
        $link->link_title = $input['link_title'];
        $link->link_url = $input['link_url'];
        $link->link_order = $input['link_order'];
        $input = Input::except('_token');
        $rules = [
            'link_name'=>'required',
            'link_url' =>'required',
        ];
        $message = [
            'link_name.required' => '链接名称不能为空！',
            'link_url.required' =>  '链接地址不能为空！',
        ];
        $validator = \Validator::make($input,$rules,$message);
        if($validator->passes()){
            if($link->save()){
                return redirect('admin/links');
            }else{
                return back()->withErrors('新增链接失败！');
            }
        }else{
            return back()->withErrors($validator);
        }

    }
    //admin.link.{link}(get) 修改
    public function edit($link_id)
    {
     $data = Links::find($link_id);
     return view('admin.links.edit',compact('data'));
    }
    //admin.link.{link}(put)  处理修改
    public function update($link_id)
    {
      $input = Input::except('_token','_method');
      $rules = [
          'link_name'=>'required',
          'link_url' =>'required',
      ];
      $message = [
         'link_name.required' => '链接名称不能为空！',
         'link_url.required' =>  '链接地址不能为空！',
      ];
      $validator = \Validator::make($input,$rules,$message);
      if($validator->passes()){
          $re = Links::where('link_id',$link_id)->update($input);
          if($re){
              return redirect('admin/links');
          }else{
              return back()->withErrors('数据异常，修改失败！');
          }
      }else{
          return back()->withErrors($validator);
      }
    }
   //逻辑删除
    public function del($link_id)
    {
        $link = Links::find($link_id);
        $link->link_isdel = 1;
        $re = $link->update();
        if($re){
            return redirect('admin/links');
        }else{
            return back()->withErrors('数据异常，删除失败！');
        }
    }
    //回收站
    public function recycle()
    {
        return view('admin.links.recycle');
    }
    //还原
    public function restore($link_id)
    {
       $re = Links::restore($link_id);
       if($re){
           return redirect(\URL::action('Admin\LinksController@recycle'));
       }else{
           return back()->withErrors('数据异常，还原失败！');
       }
    }

    //admin.link.{link}(delete) 删除
    public function destroy($link_id)
    {
       return Links::del($link_id);
    }
    //批量删除
    public function delLinkAll()
    {
        $link_id = Input::except('_token','ord');
        if($link_id){
            $re = Links::delLogicAll($link_id['id']);
            if($re){
                return redirect('admin/links');
            }else{
                return back()->withErrors('数据异常，批量删除失败');
            }
        }else{
                return redirect('admin/links')->withErrors('请选择要删除的记录数');
        }
    }
    //批量还原
    public function restoreAll(Request $request)
    {
        $link_id = $request->all();
        if(isset($link_id['id'])){
            $re = Links::restoreAll($link_id['id']);
            if($re) {
                return redirect(\URL::action('Admin\LinksController@recycle'));
            }else{
                return back()->withErrors('数据异常，批量还原失败');
            }
        }else{
            return redirect(URL::action('Admin\LinksController@recycle'))->withSuccess('请选择还原的数据');
        }
    }
    //响应回调函数
    public function changeOrder()
    {
        $input = Input::all();                 //接收数据
        $id = $input['filed_id'];             //字段id值
        $orderName = $input['order_name'];    //排序字段名
        $order = $input['filed_order'];      //排序order值
        //$model = $input['model'];             //所属模型  （未实现可变类）
        $input = Links::find($id);
        $input->$orderName = $order;
        $re = $input->update();
        if($re){
            $data = [
                'status'=>0,
                'msg'=> '分类排序更新成功!',
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'=> '分类排序更新失败,请稍后重试!',
            ];
        }
        return $data;


    }

}
