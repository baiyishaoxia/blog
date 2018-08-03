@extends('layouts.master')

@section('title',$product->art_title)
@section('my-css')
    {{Html::style('admin/mobile/css/swipe.css')}}
@endsection

@section('content')
    <div class="page bk_content" style="top: 0;">
        {{--轮播图--}}
        <div class="addWrap">
            <div class="swipe" id="mySwipe">
                <div class="swipe-wrap">
                    @foreach($imgs as $key => $val)
                        <div>
                            <a href="javascript:;"><img class="img-responsive" src="{{Storage::url($val)}}" /></a>
                        </div>
                    @endforeach
                </div>
            </div>
            <ul id="position">
                @foreach($imgs as $index => $pdt_image)
                    <li class={{$index == 0 ? 'cur' : ''}}></li>
                @endforeach
            </ul>
        </div>

    <div class="weui_cells_title">
        <span class="bk_title">{{$product->art_title}}</span>
        <span class="bk_price" style="float: right">${{$product->art_order}}</span>
    </div>

    <div class="weui_cells">
        <div class="weui_cell">
            <p class="bk_summary">{{$product->art_discription}}</p>
        </div>
    </div>

    <div class="weui_cells_title">详细介绍</div>
        <div class="weui_cells">
            <div class="weui_cells">
                {!! $product->art_content !!}
            </div>
        </div>

</div>

    {{--购物车--}}
<div class="bk_fix_bottom">
    <div class="bk_half_area">
        <button class="weui_btn weui_btn_primary" onclick="_addCart();">加入购物车</button>
    </div>
    <div class="bk_half_area">
        <button class="weui_btn weui_btn_default" onclick="_toCart()">查看购物车(<span id="cart_num" class="m3_price">{{$count}}</span>)</button>
    </div>
</div>

@endsection

@section('my-js')
    {{Html::script('admin/mobile/js/swipe.min.js')}}
    <script>
        //轮播
        var bullets = document.getElementById('position').getElementsByTagName('li');
        Swipe(document.getElementById('mySwipe'), {
            auto: 2000,
            continuous: true,
            disableScroll: false,
            callback: function(pos) {
                var i = bullets.length;
                while (i--) {
                    bullets[i].className = '';
                }
                bullets[pos].className = 'cur';
            }
        });
        //加入购物车
        function _addCart() {
            var product_id = "{{$product->art_id}}";
            $.ajax({
                type: "GET",
                url: '{{URL::action('Admin\MobileApi\CartController@addCart')}}' +'/'+ product_id,
                dataType: 'json',
                cache: false,
                success: function(data) {
                    if(data == null) {
                        $('.bk_toptips').show();
                        $('.bk_toptips span').html('服务端错误');
                        setTimeout(function() {$('.bk_toptips').hide();}, 2000);
                        return;
                    }
                    if(data.status != 0) {
                        $('.bk_toptips').show();
                        $('.bk_toptips span').html(data.message);
                        setTimeout(function() {$('.bk_toptips').hide();}, 2000);
                        return;
                    }

                    var num = $('#cart_num').html();
                    if(num == '') num = 0;
                    //点击购物车后将原来已有的购物车数据转为整形 再加1
                    $('#cart_num').html(Number(num) + 1);

                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                    $('.bk_toptips').show();
                    $('.bk_toptips span').html('请先登录!');
                    setTimeout(function() {$('.bk_toptips').hide();}, 2000);
                    return;
                }
            });
        }
        //查看购物车
        function _toCart() {
            location.href = '{{URL::action('Admin\MobileApi\CartController@getCart')}}';
        }
    </script>
@endsection