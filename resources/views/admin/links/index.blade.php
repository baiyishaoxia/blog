@extends('layouts.admin')
@section('content')
    {{--<meta name="csrf-token" content="{{ csrf_token() }}">--}}
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 分类管理
    </div>
    <!--面包屑导航 结束-->

    <!--结果页快捷搜索框 开始-->
    <div class="search_wrap">
        <form  action="{{url('admin/delAll')}}" method="POST" id="form1">
            {{csrf_field()}}
            <input type="hidden" name="id" class="export_ids" value="">
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
                    <td><input type="text" name="keywords" value="{{Request::get("keywords", "")}}" placeholder="关键字"></td>
                    <td><input type="submit" name="sub" value="查询"></td>
                </tr>
            </table>
        </form>
    </div>
    <!--结果页快捷搜索框 结束-->

    <!--搜索结果页面 列表 开始-->
    <form  method="POST" name="dereform" id="form2">
        {{ csrf_field() }}
        <div class="result_wrap">
            <div class="result_title">
                <h3>快捷操作</h3>
            </div>
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/links/create')}}"><i class="fa fa-plus"></i>添加链接</a>
                    <a href="javascript:void(0)" id="btnDel"><i class="fa fa-recycle"></i>批量删除</a>
                    <a href="{{URL::action('Admin\LinksController@recycle')}}"><i class="fa fa-recycle"></i>回收站</a>
                    <a href="javascript:;" url="{{ URL::action('Common\ExcelController@getExportLink') }}" class="fa export">导出</a>
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
                    @foreach($data as $key => $v)
                    <tr>
                        <th width="3%"><input type="checkbox" name="id[]" value="{{$v->link_id}}"/></th>
                        <td class="tc">
                            {{--排序: 需要参数 本身框位置,id字段值，url,模型类--}}
                            <input type="text" name="ord[]" onchange="commonChangeOrder(this,'{{$v->link_id}}','link_order','{{url('admin/link/changeOrder')}}','Links')" value="{{$v->link_order}}" >
                        </td>
                        <td class="tc">{{$v->link_id}}</td>
                        <td>
                            <a href="{{$v->link_url}}" target="_blank">{{$v->link_name}}</a>
                        </td>
                        <td>{{str_limit($v->link_title,50)}}</td>
                        <td>{{$v->link_url}}</td>
                        <td>
                            <a href="{{url('admin/links/'.$v->link_id.'/edit')}}">修改</a>
                            <a href="{{url('admin/links/del')}}/{{$v->link_id}}" onclick="return confirm('确认删除吗?')">删除</a>
                        </td>
                    </tr>
                        @endforeach
                </table>
                <div class="page_list">
                    <div>
                        {{$data->links()}}
                        <br /><span class="rows">{{$count}} </span>
                    </div>
                </div>
    </form>
    <!--搜索结果页面 列表 结束-->
    <script>
        //$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        /*公共异步排序方法  (当前值、字段名、字段值、url)*/
        function commonChangeOrder(obj,id,ordername,url,model){
            //alert(filed_id);
            var order = $(obj).val();
            $.post(url,{'_token': "{{csrf_token()}}",'filed_id':id,'order_name':ordername,'filed_order': order,'model':model },function(data){
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

        /*
         *一键删除
         */
        $("#btnDel").click(function () {
            document.dereform.action="{{url('admin/links/delAll')}}";
            document.dereform.submit();
        });
        //导出数据
        $(".export").click(function () {
            var data = $("#form1").serialize();
            var str = '';
            $("input[type='checkbox']").each(function () {
                if ($(this).is(":checked")) {
                    str+= $(this).val() + ','
                }
            });
            $(".export_ids").attr('value', str);
            var url = $(this).attr('url');
            $('#form1').attr('action',url);
            $('#form1').attr('method','get');
            $('#form1').submit();
        })

    </script>

@endsection
