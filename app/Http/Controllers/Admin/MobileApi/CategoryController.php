<?php

namespace App\Http\Controllers\Admin\MobileApi;

use App\Http\Model\Admin\MobileApi\M3Result;
use App\Http\Model\Admin\MobileApi\MobileCartItem;
use App\Http\Model\Article;
use App\Http\Model\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function getIndex()
    {
        \Log::info("进入类别");
        return view('admin.mobile_api.category');
    }

    //region   响应异步请求        tang
    public function getInfo($parent_id)
    {
        //所有分类时 根据排序获取 12 条记录
        if($parent_id == 0){
            $tree = Category::orderBy('cate_order','asc')->limit(12)->get();
            $cateInfo = Category::getCateTree($tree,'|-');
            $m3_result = new M3Result();
            $m3_result->status = 0;
            $m3_result->message = '获取成功';
            $m3_result->categorys = $cateInfo;
            return $m3_result->toJson();
        }
        //父类的子类
        if($parent_id){
            $category = Category::where('cate_pid',$parent_id)->get();
            $m3_result = new M3Result();
            $m3_result->status = 0;
            $m3_result->message = '获取成功';
            $m3_result->categorys = $category;
            return $m3_result->toJson();
        }
    }
    //endregion

    //region  文章列表         tang
    public function getProduct($cate_id)
    {
        $products = Article::where('cate_id',$cate_id)->get();
        $pid = Category::where('cate_id',$cate_id)->value('cate_pid');
        if($pid == null || $pid == 0){
            $cate_ids = Category::where('cate_pid',$cate_id)->pluck('cate_id');
            $products = Article::whereIn('cate_id',$cate_ids)->get();
        }
        return view('admin.mobile_api.product',compact('products'));
    }
    //endregion

    //region    详情         tang
    public function getProductContent(Request $request,$product_id)
    {
       $product = Article::find($product_id);
       if($product == null){
           return redirect(\URL::action('Admin\MobileApi\CategoryController@getIndex'));
       }
       $imgs = Article::get()->pluck('art_thumb','art_id');

       //当用户刷新页面时,读取cookie信息,并将信息返回,如没有信息,count初始值结算为0,点击加入购物车+1
       $count = 0;

        $member = $request->session()->get('member', '');
        if($member != '') {
            //如果用户登录了,显示购物车数量
            $cart_items = MobileCartItem::where('member_id', $member->id)->get();
            foreach ($cart_items as $cart_item) {
                if($cart_item->product_id == $product_id) {
                    $count = $cart_item->count;
                    break;
                }
            }
        } else {
            $cart = $request->cookie('cart');
            $cart_arr = ($cart!=null ? explode(',',$cart) : array() );
            foreach ($cart_arr as $value) {
                $index = strpos($value, ':');
                if (substr($value, 0, $index) == $product_id) {
                    //冒号的后面就是购买的数量
                    $count = (int)substr($value, $index + 1);
                    break;
                }
            }
        }

       return view('admin.mobile_api.pdt_content',compact('product','imgs','count'));
    }
    //endregion





}
