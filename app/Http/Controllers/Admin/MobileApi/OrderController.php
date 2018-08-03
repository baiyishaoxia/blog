<?php

namespace App\Http\Controllers\Admin\MobileApi;

use App\Http\Model\Admin\MobileApi\MobileCartItem;
use App\Http\Model\Admin\MobileApi\MobileOrder;
use App\Http\Model\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    //region   结算列表        tang
    public function getOrderCommit(Request $request,$product_ids,$is_wx){

        $product_ids_arr = $product_ids!=''?explode(',',$product_ids):array();
        $member = $request->session()->get('member','');
        $cart_items = MobileCartItem::where('member_id',$member->id)->whereIn('product_id',$product_ids_arr)->get();

        $cart_items_arr = array();
        $total_price = 0;
        foreach ($cart_items as $cart_item){
            $cart_item->product = Article::find($cart_item->product_id);
            if($cart_item->product != null){
                $total_price += $cart_item->product->art_order * $cart_item->count;
                array_push($cart_items_arr,$cart_item);
            }
        }

        return view('admin.mobile_api.order_commit')->with(['cart_items'=>$cart_items_arr,'total_price'=>$total_price]);
    }
    //endregion

    //region   订单列表        tang
    public function getOrderList(Request $request)
    {
        $member = $request->session()->get('member','');
        $orders = MobileOrder::where('member_id',$member->id)->get();
        foreach ($orders as $order){
            $order_items = MobileCartItem::where('order_id',$order->id)->get();
            $order->order_items = $order_items;
            foreach ($order_items as $order_item){
                $order_item->product = Article::find($order_item->product_id);
            }
        }
        return view('admin.mobile_api.order_list',compact('orders'));
    }
    //endregion


}
