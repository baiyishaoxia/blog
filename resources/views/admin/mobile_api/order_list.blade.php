@extends('layouts.master')

@section('title', '订单列表')

@section('content')
    @foreach($orders as $order)
        <div class="weui_cells_title">
            <span>订单号: {{$order->order_no}}</span>

            @if($order->status == 1)
                <span style="float: right;" class="bk_price">
            未支付
          </span>
            @else
                <span style="float: right;" class="bk_important">
            已支付
          </span>
            @endif

        </div>
        <div class="weui_cells">
            @foreach($order->order_items as $order_item)
                <div class="weui_cell">
                    <div class="weui_cell_hd">
                        <img src="{{Storage::url($order_item->product->art_thumb)}}" alt="" class="bk_icon">
                    </div>
                    <div class="weui_cell_bd weui_cell_primary">
                        <p class="bk_summary">{{$order_item->product->art_title}}</p>
                    </div>
                    <div class="weui_cell_ft">
                        <span class="bk_summary">{{$order_item->product->art_order}}</span>
                        <span> x </span>
                        <span class="bk_important">{{$order_item->count}}</span>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="weui_cells_tips" style="text-align: right;">合计: <span class="bk_price">{{$order->total_price}}</span>&nbsp;
            <a href="{{URL::action('Admin\MobileApi\OrderController@getDel',['id'=>$order->id])}}" onclick="return confirm('确定删除该订单吗?')"><span class="bk_price" style="color: #0C0C0C;">[删除该订单]</span></a>
        </div>
    @endforeach

     @foreach($orders as $key => $val )
         <?php $i=0; ?>
         @if($val->status == 1)
             <?php $name[$i]= $val->name; $order_no[$i] = $val->order_no; $total_price[$i] = $val->total_price;$i++;  ?>
         @else
             <?php $name = null; $order_no = null; $total_price = null; ?>
         @endif
     @endforeach

    <div class="bk_fix_bottom">
        <div class="bk_half_area">
            @if(count(\App\Http\Model\Admin\MobileApi\MobileOrder::where('status',1)->get()))
                <button class="weui_btn weui_btn_primary" onclick="_topay();">继续支付</button>
            @else
                <button class="weui_btn weui_btn_primary" onclick="javascript:void(0)">已支付</button>
            @endif
        </div>
        <div class="bk_half_area">
            <button class="weui_btn weui_btn_default" onclick="_onpay();">继续逛逛?</button>
        </div>
    </div>

    <div>
        {{$orders->links()}}
    </div>
@endsection

@section('my-js')
    <script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js" charset="utf-8"></script>
    <script type="text/javascript">
        //通过config接口注入权限验证配置
        wx.config({
            debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
            appId: '{{$wx_js_config->appId}}', // 必填，公众号的唯一标识
            timestamp: {{$wx_js_config->timestamp}} , // 必填，生成签名的时间戳
            nonceStr: '{{$wx_js_config->nonceStr}}', // 必填，生成签名的随机串
            signature: '{{$wx_js_config->signature}}',// 必填，签名
            jsApiList: ['chooseWXPay'] // 必填，需要使用的JS接口列表
        });
        //通过ready接口处理成功验证
        wx.ready(function(){
            // config信息验证后会执行ready方法，所有接口调用都必须在config接口获得结果之后，config是一个客户端的异步操作，所以如果需要在页面加载时就调用相关接口，则须把相关接口放在ready函数中调用来确保正确执行。对于用户触发时才调用的接口，则可以直接调用，不需要放在ready函数中。
        });
        //通过error接口处理失败验证
        wx.error(function(res){
            // config信息验证失败会执行error函数，如签名过期导致验证失败，具体错误信息可以打开config的debug模式查看，也可以在返回的res参数中查看，对于SPA可以在这里更新签名。
        });
    function _topay() {
        $.ajax({
            type: "POST",
            url: '{{URL::action('Admin\MobileApi\PayController@wxPay')}}',
            dataType: 'json',
            cache: false,
            data: {name: "{{json_encode($name)}}", order_no: "{{json_encode($order_no)}}", total_price: "{{json_encode($total_price)}}",_token: "{{csrf_token()}}"},
            success: function(data) {
                if(data == null) {
                    $('.bk_toptips').show();
                    $('.bk_toptips span').html('服务端错误');
                    setTimeout(function() {$('.bk_toptips').hide();}, 2000);
                    return;
                }
                wx.chooseWXPay({
                    timestamp: data.timestamp, // 支付签名时间戳，注意微信jssdk中的所有使用timestamp字段均为小写。但最新版的支付后台生成签名使用的timeStamp字段名需大写其中的S字符
                    nonceStr: data.nonceStr, // 支付签名随机串，不长于 32 位
                    package: data.package, // 统一支付接口返回的prepay_id参数值，提交格式如：prepay_id=***）
                    signType: data.signType, // 签名方式，默认为'SHA1'，使用新版支付需传入'MD5'
                    paySign: data.paySign, // 支付签名
                    success: function (res) {
                        // 支付成功后的回调函数
                        location.href = '{{URL::action('Admin\MobileApi\OrderController@getOrderList')}}';
                    }
                });
            },
            error: function(xhr, status, error) {
                console.log(xhr);
                console.log(status);
                console.log(error);
                var ua = navigator.userAgent.toLowerCase();//获取判断用的对象
                if (ua.match(/MicroMessenger/i) != "micromessenger") {
                    alert('请在微信浏览器中打开');
                }
            }
        });
    }
    function  _onpay() {
        location.href = '{{URL::action('Admin\MobileApi\CategoryController@getIndex')}}';
    }
    </script>
@endsection
