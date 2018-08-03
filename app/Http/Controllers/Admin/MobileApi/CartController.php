<?php

namespace App\Http\Controllers\Admin\MobileApi;

use App\Http\Model\Admin\MobileApi\M3Result;
use App\Http\Model\Admin\MobileApi\MobileCartItem;
use App\Http\Model\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    //region   加入购物车        tang
    public function addCart(Request $request,$product_id)
    {
        $m3_result = new M3Result();
        $m3_result->status = 0;
        $m3_result->message = "添加成功";
        // 如果当前已经登录
        $member = $request->session()->get('member', '');
        if($member != '') {
            $cart_items = MobileCartItem::where('member_id', $member->id)->get();
            $exist = false;
            foreach ($cart_items as $cart_item) {
                if($cart_item->product_id == $product_id) {
                    $cart_item->count ++;
                    $cart_item->save();
                    $exist = true;
                    break;
                }
            }
            if($exist == false) {
                $cart_item = new MobileCartItem();
                $cart_item->product_id = $product_id;
                $cart_item->count = 1;
                $cart_item->member_id = $member->id;
                $cart_item->save();
            }
            return $m3_result->toJson();
        }


        //1:3,2:1,3:4,...
        $cart = $request->cookie('cart');
        //return $cart;
        //字符串打散为数组
        $cart_arr = ($cart!=null ? explode(',',$cart) : array());
        $count = 1;
        //传引用就能直接修改数组的值
        foreach ($cart_arr as &$value){
            $index = strpos($value,':');
            if(substr($value,0,$index) == $product_id){
                //冒号的后面就是购买的数量
                $count = ((int)substr($value,$index+1))+1;
                $value = $product_id.':'.$count;
                break;
            }
        }
        if($count == 1){
            //说明购物车没有信息 ,这是第一次购买
            array_push($cart_arr,$product_id.':'.$count);
        }

        //返回响应信息
        return response($m3_result->toJson())->withCookie('cart',implode(',',$cart_arr));
    }
    //endregion

    //region   结算        tang
    public function getCart(Request $request)
    {
        $cart_items = array();
        $cart = $request->cookie('cart');
        $cart_arr = ($cart!=null ? explode(',',$cart) : array() );

        $member = $request->session()->get('member','');
        if($member != null){
            $cart_items = $this->syncCart($member->id,$cart_arr);
            return response()->view('admin.mobile_api.cart',['cart_items'=>$cart_items])->withCookie('cart',null);
        }

        foreach ($cart_arr as $key => $value){
            $index = strpos($value,':');
            $cart_item = new MobileCartItem();
            $cart_item->id = $key;
            $cart_item->product_id = substr($value,0,$index);
            $cart_item->count = substr($value,$index+1);
            $cart_item->product = Article::find($cart_item->product_id);
            if($cart_item->product != null){
                array_push($cart_items,$cart_item);
            }
        }

       return view('admin.mobile_api.cart',compact('cart_items'));
    }
    //endregion

    //region   同步购物车        tang
    private function syncCart($member_id,$cart_arr){
        $cart_items = MobileCartItem::where('member_id', $member_id)->get();

        $cart_items_arr = array();
        foreach ($cart_arr as $value) {
            $index = strpos($value, ':');
            $product_id = substr($value, 0, $index);
            $count = (int) substr($value, $index+1);

            // 判断离线购物车中product_id 是否存在 数据库中
            $exist = false;
            foreach ($cart_items as $temp) {
                if($temp->product_id == $product_id) {
                    if($temp->count < $count) {
                        $temp->count = $count;
                        $temp->save();
                    }
                    $exist = true;
                    break;
                }
            }

            // 不存在则存储进来
            if($exist == false) {
                $cart_item = new MobileCartItem();
                $cart_item->member_id = $member_id;
                $cart_item->product_id = $product_id;
                $cart_item->count = $count;
                $cart_item->save();
                $cart_item->product = Article::find($cart_item->product_id);
                array_push($cart_items_arr, $cart_item);
            }
        }

        // 为每个对象附加产品对象便于显示
        foreach ($cart_items as $cart_item) {
            $cart_item->product = Article::find($cart_item->product_id);
            array_push($cart_items_arr, $cart_item);
        }
        return $cart_items_arr;
    }
    //endregion

    //region   删除订单        tang
    public  function getDelCart(Request $request){
       $m3_result = new M3Result();
       $m3_result->status = 0;
       $m3_result->message = '删除成功!';

       $product_ids = $request->input('product_ids','');
       if($product_ids == ''){
          $m3_result->status = 1;
          $m3_result->message = '订单ID为空!';
          return $m3_result->toJson();
       }
       $product_ids_arr = explode(',',$product_ids);
       $member = $request->session()->get('member', '');
        if($member != '') {
            // 已登录
            MobileCartItem::whereIn('product_id', $product_ids_arr)->delete();
            return $m3_result->toJson();
        }

       //未登录
       $cart = $request->cookie('cart');
       $cart_arr = ($cart != null ? explode(',',$cart) : array());
       foreach ($cart_arr as $key => $val){
           $index = strpos($val,':');
           $product_id = substr($val,0,$index);
           //存在,删除
           if(in_array($product_id, $product_ids_arr)){
               //从数组中移除元素，并用新元素取代它：数组,删除开始位置,个数,[可选:新元素]
               array_splice($cart_arr,$key,1);
               continue;
           }
       }
        return response($m3_result->toJson())->withCookie('cart',implode(',',$cart_arr));
    }
    //endregion

}
