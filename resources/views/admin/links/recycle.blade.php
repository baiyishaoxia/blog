@extends('layouts.admin')
@section('content')
    {{--<meta name="csrf-token" content="{{ csrf_token() }}">--}}
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 回收站
    </div>
    <!--面包屑导航 结束-->

    <!--结果页快捷搜索框 开始-->
    <div class="search_wrap">
        <form  method="POST" name="dereform">
            {{ csrf_field() }}
            <table class="search_tab">
                <tr>
                    <th width="120">选择分类:</th>
                    <td>
                        <select onchange="javascript:location.href=this.value;">
                            <option value="">全部</option>
                            <option value="http://www.baidu.com">百度</option>
                            <option value="http://www.sina.com">新浪</option>
                        </select>
                    </td>
                    <th width="70">关键字:</th>
                    <td><input type="text" name="keywords" placeholder="关键字"></td>
                    <td><input type="submit" name="sub" value="查询"></td>
                </tr>
            </table>
        </form>
    </div>
    <!--结果页快捷搜索框 结束-->

    <!--搜索结果页面 列表 开始-->
    <form  method="POST" name="deform">
        {{ csrf_field() }}
        <div class="result_wrap">
            <div class="result_title">
                <h3>快捷操作</h3>
            </div>
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/links/create')}}"><i class="fa fa-plus"></i>添加链接</a>
                    <a href="javascript:void(0)" id="restoreAll"><i class="fa fa-recycle"></i>批量还原</a>
                    <a href="{{url('admin/links')}}"><i class="fa fa-recycle"></i>友情链接列表</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th width="75"><input type="checkbox"  class="checkall" /></th>
                        <th class="tc">排序</th>
                        <th class="tc">ID</th>
                        <th>链接名称</th>
                        <th width="350px">链接描述</th>
                        <th>链接地址</th>
                        <th>操作</th>
                    </tr>
                    @foreach(\App\Http\Model\Links::getLinksRecyList() as $key => $v)
                    <tr>
                        <th width="3%"><input type="checkbox" name="id[]" value="{{$v->link_id}}"/></th>
                        <td class="tc">
                            {{--排序: 需要参数 本身框位置,id值--}}
                            <input type="text" name="ord[]" onchange="changeOrder(this,{{$v->link_id}})" value="{{$v->link_order}}" >
                        </td>
                        <td class="tc">{{$v->link_id}}</td>
                        <td>
                            <a href="{{$v->link_url}}" target="_blank">{{$v->link_name}}</a>
                        </td>
                        <td>{{str_limit($v->link_title,50)}}</td>
                        <td>{{$v->link_url}}</td>
                        <td>
                            <a href="{{url('admin/links/restore')}}/{{$v->link_id}}">还原</a>
                            <a href="javascript:void(0)" onclick="delLink({{$v->link_id}})">删除</a>
                        </td>
                    </tr>
                        @endforeach
                </table>
                <div class="page_list">
                    <div>
                        {{$data = \App\Http\Model\Links::getLinksRecyList()->links()}}
                    </div>
                </div>
    </form>
    <!--搜索结果页面 列表 结束-->
    <script>
        //$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        //排序更新动作
        function changeOrder(obj,cate_id){
            var cate_order = $(obj).val();
            $.post("{{url('admin/cate/changeOrder')}}",{'_token': "{{csrf_token()}}",'cate_id':cate_id,'cate_order': cate_order },function(data){
               //alert(data.msg);
                if(data.status == 0){
                    layer.msg(data.msg, {icon: 6});
                    location.reload();
                }else{
                    layer.msg(data.msg, {icon: 5});
                }
            });
        }
        //删除提示
        function delLink(link_id){
            layer.confirm('您确定要删除这个分类吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.post('{{url('admin/links')}}/'+link_id,{'_method':'delete','_token':"{{csrf_token()}}"},function(data){
                   if(data.status == 0){
                       layer.msg(data.msg, {icon: 6});
                       location.reload();
                   }else{
                       layer.msg(data.msg, {icon: 5});
                   }
                });
            }, function(){
                layer.msg('主人', {
                    time: 20000, //20s后自动关闭
                    btn: ['谢谢', '我要留在主人身边']
                });
            });
        }
        /*
        *全选按钮
        */
        var isCheckAll = false;
        $(".checkall").click(function (){
            if (isCheckAll) {
                $("input[type='checkbox']").each(function() {
                    this.checked = false;
                });
                isCheckAll = false;
            } else {
                $("input[type='checkbox']").each(function() {
                    this.checked = true;
                });
                isCheckAll = true;
            }
        });
        //一键还原
        $("#restoreAll").click(function () {
            //alert("{{url('admin/restoreAll')}}");
            document.deform.action="{{url('admin/links/restoreAll')}}";
            document.deform.submit();
        })
    </script>

@endsection
