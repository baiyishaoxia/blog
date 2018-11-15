<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>{{isset($match['title'])?$match['title']:"模板2"}}</title>
    @include('admin.article_tmp.static_template.layout')
</head>
<body>
@if(isset($match))
    <div class="mould-template">
    <div class="side-header navFix">
        @if($match['match_detail'])
            @foreach($match['match_detail'] as $key=>$val)
                @if($val->is_show_menu)
                <a href="#part{{$key+1}}" class="{{$key == 0?'active':''}}">{{$val->title}}</a>
                @endif
            @endforeach
        @endif
    </div>
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
                                <a href="{{isset($sign_up)?'http://www.baidu.com':'javascript:void(0)'}}" target="_blank" style="background:url({{Storage::url($vv['file_url'])}}) no-repeat center center;"></a>
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
        @if(isset($sign_up))
            <div class="nowApply"><a href="http://www.baidu.com">活动</a></div>
        @else
            <div class="nowApply"><a href="javascript:void(0)">活动</a></div>
        @endif
        <div class="time">活动征集：{{\Carbon\Carbon::parse($match['start_time'])->format('Y-m-d').'——'.\Carbon\Carbon::parse($match['end_time'])->format('Y-m-d')}}</div>
    <div class="mould-cont">
        <div class="w1200">
            @if($match['match_detail'])
                @foreach($match['match_detail'] as $k=>$v)
                    @if($v->is_show_menu)
                    <div class="box wow zoomIn " id="part{{$k+1}}">
                        <div class="tt">{{$v->title}}</div>
                        <div class="text">
                            <div class="text-border">{!! $v->template_text !!}</div>
                        </div>
                    </div>
                    @endif
                @endforeach
            @endif
        </div>
    </div>
</div>
@else
    <div class="mould-template mould-template-view">
        <div class="side-header navFix">
            <a href="#part1" class="active">活动简介</a>
            <a href="#part2">活动目的</a>
            <a href="#part3">活动内容</a>
            <a href="#part4">活动安排</a>
            <a href="#part5">活动规则</a>
            <a href="#part6">活动设置</a>
            <a href="#part7">活动奖励</a>
            <a href="#part8">活动意义</a>
            <a href="#part9">活动方式</a>
            <a href="#part10">活动补充</a>
        </div>
        <div class="banners" style="background: url(/home/images/mode.jpg) no-repeat center top">
            <div class="w1200">
                <div class="title">“创新”<br> 无与伦比的演出</div>
                <div class="time">活动时间：2018-09-13——2018-12-21</div>
            </div>
        </div>
        <div class="mould-cont">
            <div class="w1200">
                <div class="box wow zoomIn " id="part1">
                    <div class="tt">一：活动简介</div>
                    <div class="text"><div class="text-border"></div></div>
                </div>
                <div class="box wow zoomIn " id="part2">
                    <div class="tt">二：活动目的</div>
                    <div class="text"><div class="text-border"></div></div>
                </div>
                <div class="box wow zoomIn " id="part3">
                    <div class="tt">三：活动内容</div>
                    <div class="text"><div class="text-border"></div></div>
                </div>
                <div class="box wow zoomIn " id="part4">
                    <div class="tt">四：活动安排</div>
                    <div class="text"><div class="text-border"></div></div>
                </div>
                <div class="box wow zoomIn " id="part5">
                    <div class="tt">五：活动规则</div>
                    <div class="text"><div class="text-border"></div></div>
                </div>
                <div class="box wow zoomIn " id="part6">
                    <div class="tt">六：活动设置</div>
                    <div class="text"><div class="text-border"></div></div>
                </div>
                <div class="box wow zoomIn " id="part7">
                    <div class="tt">七：活动奖励</div>
                    <div class="text"><div class="text-border"></div></div>
                </div>
                <div class="box wow zoomIn " id="part8">
                    <div class="tt">八：活动意义</div>
                    <div class="text"><div class="text-border"></div></div>
                </div>
                <div class="box wow zoomIn " id="part9">
                    <div class="tt">九：活动方式</div>
                    <div class="text"><div class="text-border"></div></div>
                </div>
                <div class="box wow zoomIn " id="part10">
                    <div class="tt">十：活动补充</div>
                    <div class="text"><div class="text-border"></div></div>
                </div>
            </div>
        </div>
    </div>
@endif


<!-- footer -->
<script>
jQuery(".mould-slideBox").slide({titCell:".hd ul li", mainCell: ".bd .picList", effect: "left", autoPlay: true });
    //定位导航
    $('.side-header').navScroll({
        mobileDropdown: true,
        scrollSpy: true
    });

    if (!(/msie [6|7|8|9]/i.test(navigator.userAgent))){
        new WOW().init();
    };

</script>
</body>
</html>
