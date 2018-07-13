<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Article;
use App\Http\Model\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class CategoryController extends CommonController
{
    //admin.category(get) 全部分类列表
    public function index()
    {
        //第①种初始化数据(无限级联)
        //$cateInfo = Category::moreTree();
        $tree = Category::orderBy('cate_order','asc')
            ->get();
        foreach ($tree as $key => $value){
            $tree[$key]['cate_name'] = '<span class="folder-open"></span>'.$value['cate_name'];
        }
        $cateInfo = Category::getCateTree($tree,'<span class="folder-line"></span>');
        //获取当前的分页数
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        //实例化collect方法
        $collection = new Collection($cateInfo);
        //定义一下每页显示多少个数据
        $perPage = 10;
        //获取当前需要显示的数据列表
        $currentPageSearchResults = $collection->slice(($currentPage-1) * $perPage, $perPage)->all();
        //创建一个新的分页方法
        $paginatedSearchResults= new LengthAwarePaginator($currentPageSearchResults, count($collection), $perPage);
        $data = $paginatedSearchResults->setPath('/admin/category');
        $count = '当前第'.$data->currentPage().'页，每页'.$data->perPage().'条数据,'.'总共'.$data->total().'条数据。';
        //第②种初始化数据(二级联)
        //$cateInfo = Category::tree();
        return view('admin.category.index',compact('data','count'));
    }
    //响应回调函数
    public function changeOrder()
    {
      $input = Input::all();
      $cate = Category::find($input['cate_id']);
      $cate->cate_order = $input['cate_order'];
      $re = $cate->update();
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

    //admin.category.create(get) 添加分类
    public function create()
    {
        $data = Category::moreTree();
        //$data = Category::where('cate_pid',0)->get();
        return view('admin.category.add',compact('data'));
    }

    //admin.category(post) 添加分类处理提交
    public function store()
    {
       //$input = Input::all();
       $input = Input::except('_token'); //除_token之外数据皆可入库
       $rules = [
           'cate_name' =>'required',
       ];
       $message = [
           'cate_name.required'=>'分类名称不能为空!',
       ];
       if (!$input['cate_order']){
           $input['cate_order'] = 0;
       }
       $validator = \Validator::make($input,$rules,$message);
       if($validator->passes()){
          $re = Category::create($input);
          if($re){
              return redirect('admin/category');
          }else{
              return back()->withErrors('数据填充失败,请稍后重试!');
          }
       }else{
          return back()->withErrors($validator);
       }
    }

    //admin.category.{category}.edit(get) 编辑分类
    public function edit($cate_id)
    {
       $filed = Category::find($cate_id);
       //无限级联展示
       $data = Category::moreEditTree($cate_id);
       return view('admin.category.edit',compact('filed','data'));
       //这里对应上面第②中分类方式(2级联)
       //$data = Category::where('cate_pid',0)->get();
       //return view('admin.category.edit',compact('filed','data'));
    }
    //admin.category.{category}(put) 更新分类处理
    public function update($cate_id)
    {
        $input = Input::except('_token','_method');
        if($input['cate_pid']!= $cate_id) {
            $input['cate_pid'] = $input['cate_pid'];
        }else{
            return back()->withInput()->withErrors("父级不可以是本身");
        }
        if(Category::where('cate_pid',$cate_id)->count()>0  && $input['cate_pid']!=null){
            return back()->withInput()->withErrors("该父级有子级,请先删除子级后修改");
        }
        $re = Category::where('cate_id',$cate_id)->update($input);
        if($re){
            return redirect('admin/category');
        }else{
            return back()->withErrors('分类信息更新失败,请稍后重试!');
        }
    }

    //admin.category.show(get) 显示单个分类信息
    public function show()
    {

    }
    //admin.category.{category}(delete) 删除单个分类
    public function destroy($cate_id)
    {
        $re = Category::where('cate_id',$cate_id)->delete();
        Category::where('cate_pid',$cate_id)->update(['cate_pid'=>0]);
        if($re){
            $data = [
               'status'=>0,
                'msg'  =>'恭喜,分类删除成功!',
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'  =>'抱歉,分类删除失败,请稍后重试!',
            ];
        }
        return $data;
    }

    //region   批量删除        tang
    public function postDel(Request $request)
    {
        $input = $request->all();
        try{
            if (Article::whereIn('cate_id',$input['id'])->count()>0){
                return redirect('admin/category')->withSuccess("分类下存在内容，请删除完后再进行此操作");
            }
            if(Category::whereIn('cate_pid',$input['id'])->count()>0){
                return back()->withInput()->withErrors("该父级有子级,请先删除子级后删除");
            }
            $re = Category::whereIn('cate_id',$input['id'])->delete();
            if($re){
                return back()->withErrors("删除成功");
            }else{
                return back()->withErrors("数据异常,删除失败");
            }
        }catch (\Exception $e){
            //AdminErrorLog::log($e);
            return back()->withErrors("操作异常");
        }
    }
    //endregion

}
