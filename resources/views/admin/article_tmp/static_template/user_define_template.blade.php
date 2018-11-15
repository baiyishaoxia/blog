<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>{{isset($match['title'])?$match['title']:"自定义模板"}}</title>
    @include('admin.article_tmp.static_template.layout')
</head>
<body>
<div class="mould-template-cust" style="min-height:800px">
    <div class="mould-logo">
        <div class="w1200">
            <a href="javascript:void(0);" class="logo fl"><img src="{{URL::asset('/admin/tmp/images/logo.png')}}"></a>
        </div>
    </div>
    @if(isset($match))
        @if(count($match['images']) > 1)
            <div class="mould-slideBox">
                <div class="hd">
                    <ul>
                        @foreach($match['images'] as $k=>$v)
                            <li></li>
                        @endforeach
                    </ul>
                </div>
                <div class="bd">
                    <ul class="picList">
                        @foreach($match['images'] as $kk=>$vv)
                            <li>
                                <a href="javascript:void(0)" target="_blank" style="background:url({{Storage::url($vv['file_url'])}}) no-repeat center center;"></a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @else
            <div class="mould-banners">
                <a href="{{isset($sign_up)?'http://www.baidu.com':'javascript:void(0)'}}"><img src="{{$match['images']?Storage::url($match['images'][0]['file_url']):URL::asset('/admin/tmp/images/mode5.png')}}"></a>
            </div>
        @endif
    @endif
    @if(isset($sign_up))
        <div class="nowApply"><a href="http://www.baidu.com">活动</a></div>
    @else
        <div class="nowApply"><a href="javascript:void(0)">活动</a></div>
    @endif
    <div class="w1200">
        <div class="mould-cust">
            {!! isset($match['match_detail'])?$match['match_detail']:"自定义模板" !!}
        </div>
    </div>
</div>


<!-- footer -->
@include('admin.article_tmp.static_template.foot')
<script>
jQuery(".mould-slideBox").slide({titCell:".hd ul li", mainCell: ".bd .picList", effect: "left", autoPlay: true });
</script>
</body>
</html>
