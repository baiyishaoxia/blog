<!DOCTYPE html>
<html lang="en">
<head>
    <title>后台管理系统</title>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="{{asset('admin/style/img/logo.ico')}}" type="image/x-icon" />
    <link rel="stylesheet" href="{{asset('admin/style/css/ch-ui.admin.css')}}">
    <link rel="stylesheet" href="{{asset('admin/style/css/admin.css')}}">
    <link rel="stylesheet" href="{{asset('admin/style/font/css/font-awesome.min.css')}}">
    <script type="text/javascript" src="{{asset('admin/style/js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin/style/js/btnsave.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin/style/js/ch-ui.admin.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin/style/js/admin.js')}}"></script>
    <script type="text/javascript" src="{{asset('org/layer/layer.js')}}"></script>
    <script type="text/javascript" charset="utf-8" src="{{asset('org/ueditor/ueditor.config.js')}}"></script>
    <script type="text/javascript" charset="utf-8" src="{{asset('org/ueditor/ueditor.all.min.js')}}"> </script>
    <script type="text/javascript" charset="utf-8" src="{{asset('org/ueditor/lang/zh-cn/zh-cn.js')}}"></script>
    {{Html::style('admin/style/css/style.css')}}
    @yield('css')
    @yield('js')
</head>
<style>
    .active{background-color: #0C4B77; }
</style>
<body>
@yield('content')

@include('admin.msg')
@yield('my-js')
<script>
        $(document).ready(function(){
            $("#menu-nav li").eq(0).addClass("active");
            var oUl = document.getElementById("menu-nav");
            var aLi = oUl.getElementsByTagName("li");
            var mUl = document.getElementById("menu_box");
            oUl.onclick = function(ev){
                var target = ev.target || ev.srcElement;
                if(target.nodeName.toLowerCase() == "a"){
                    var that=target;
                    var index;
                    for(var i=0;i<aLi.length;i++){
                        if($(aLi[i]).find("a").eq(0).attr("href") == target)index=i;
                    }
                    $(mUl).find("ul").hide();
                    $(oUl).find("li").removeClass();
                    if(index>=0){
                        index = index+1;
                        $("#menu-nav li:nth-child("+index+")").addClass("active");
                        $("#menu_box ul:nth-child("+index+")").css("display","block");
                    }
                }
            }
        })
</script>
</body>
</html>