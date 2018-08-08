<?php

namespace App\Http\Controllers\Admin\MobileApi;

use App\Common\wxpay\WXTool;
use App\Http\Model\Admin\MobileApi\MobileCartItem;
use App\Http\Model\Admin\MobileApi\MobileOrder;
use App\Http\Model\Admin\MobileApi\MobileOrderItem;
use App\Http\Model\Admin\MobileApi\WXJsConfig;
use App\Http\Model\Article;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    //region   结算列表        tang
    public function getOrderCommit(Request $request)
    {
        \Cache::forget('getOrderList:_2');
        // 获取微信重定向返回的code
        $code = $request->input('code', '');
        if($code != '') {
            //获取code码，以获取openid
            $openid = WXTool::getOpenid($code);
            // 将openid保存到session
            $request->session()->put('openid', $openid);
        }
        $product_ids = $request->input('product_ids', '');

        $product_ids_arr = $product_ids!=''?explode(',',$product_ids):array();
        $member = $request->session()->get('member','');
        $cart_items = MobileCartItem::where('member_id',$member->id)->whereIn('product_id',$product_ids_arr)->get();

        $order = new MobileOrder();
        $order->member_id = $member->id;
        $order->save();

        $cart_items_arr = array();
        $cart_items_ids_arr = array();
        $name = '';
        $total_price = 0;
        foreach ($cart_items as $cart_item){
            $cart_item->product = Article::find($cart_item->product_id);
            if($cart_item->product != null){
                $total_price += $cart_item->product->art_order * $cart_item->count;
                $name .= ('《'.$cart_item->product->art_title.'》');
                array_push($cart_items_arr,$cart_item);
                array_push($cart_items_ids_arr, $cart_item->id);

                $order_item = new MobileOrderItem();
                $order_item->order_id = $order->id;
                $order_item->product_id = $cart_item->product_id;
                $order_item->count = $cart_item->count;
                $order_item->pdt_snapshot = json_encode($cart_item->product);
                $order_item->save();
            }
        }
        MobileCartItem::whereIn('id', $cart_items_ids_arr)->delete();
        $order->name = $name;
        $order->total_price = $total_price;
        $order->order_no = 'E'.time().''.$order->id;
        $order->save();

        //JSSDK相关
        $access_token = WXTool::getAccessToken();
        $jsapi_ticket = WXTool::getJsApiTicket($access_token);
        $noncestr = WXTool::createNonceStr();
        $timestamp = time();
        $url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
        // 签名
        $signature = WXTool::signature($jsapi_ticket, $noncestr, $timestamp, $url);
        // 返回微信参数
        $wx_js_config = new WXJsConfig();
        $wx_js_config->appId = config('wx_config.APPID');
        $wx_js_config->timestamp = $timestamp;
        $wx_js_config->nonceStr = $noncestr;
        $wx_js_config->signature = $signature;
        //JSSDK end

        return view('admin.mobile_api.order_commit')->with(['cart_items'=>$cart_items_arr,'total_price'=>$total_price])
                                                              ->with(['name'=>$name,'order_no'=>$order->order_no,'wx_js_config'=>$wx_js_config]);
    }
    //endregion

    //region   订单列表 (支付状态)       tang
    public function getOrderList(Request $request)
    {
        //开启缓存
        $minutes=Carbon::now()->addMinute(10);
        $page = $request->page?$request->page:1;
        $data = \Cache::remember('getOrderList:'.'_'.$page,$minutes,function () use($request) {
            $member = $request->session()->get('member', '');
            $orders = MobileOrder::where('member_id', $member->id)->paginate(\Config::get('custom.order_page'));
            foreach ($orders as $order) {
                $order_items = MobileOrderItem::where('order_id', $order->id)->get();
                $order->order_items = $order_items;
                foreach ($order_items as $order_item) {
                    //$order_item->product = Article::find($order_item->product_id);
                    //直接使用快照
                    $order_item->product = json_decode($order_item->pdt_snapshot);
                }
            }
            //JSSDK相关
            $access_token = WXTool::getAccessToken();
            $jsapi_ticket = WXTool::getJsApiTicket($access_token);
            $noncestr = WXTool::createNonceStr();
            $timestamp = time();
            $url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
            // 签名
            $signature = WXTool::signature($jsapi_ticket, $noncestr, $timestamp, $url);
            // 返回微信参数
            $wx_js_config = new WXJsConfig();
            $wx_js_config->appId = config('wx_config.APPID');
            $wx_js_config->timestamp = $timestamp;
            $wx_js_config->nonceStr = $noncestr;
            $wx_js_config->signature = $signature;

            $data['wx_js_config'] = $wx_js_config;
            $data['orders'] = $orders;
            return $data;
        });
        //JSSDK end
        //return view('admin.mobile_api.order_list',compact('orders','wx_js_config'));
        return view('admin.mobile_api.order_list')->with(['orders'=>$data['orders'],'wx_js_config'=>$data['wx_js_config']]);
    }
    //endregion

    //region   订单取消        tang
    public function getDel($id)
    {
        if($id){
            \DB::beginTransaction();
            $re1 = MobileOrder::destroy($id);
            $re2 = MobileOrderItem::where('order_id',$id)->delete();
            if($re1 && $re2){
                \DB::commit();
                return back()->withErrors('删除成功!');
            }else{
                \DB::rollBack();
                return back()->withErrors('删除失败!');
            }
        }
        return ;
    }
    //endregion

}
