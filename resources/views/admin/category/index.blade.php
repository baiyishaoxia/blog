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
        <form action="" method="post">
            <table class="search_tab">
                <tr>
                    <th width="120">选择分类:</th>
                    <td>
                        {{Form::select('cate_id',\App\Http\Model\Category::tree2(2),Request::get('cate_id'))}}
                    </td>
                    <th width="70">关键字:</th>
                    <td><input type="text" name="keywords" placeholder="关键字"></td>
                    <td><a class="btn-search" href="javascript:void (0)">查询</a></td>
                </tr>
            </table>
        </form>
    </div>
    <!--结果页快捷搜索框 结束-->

    <!--搜索结果页面 列表 开始-->
    {{Form::open()}}
        <div class="result_wrap">
            <div class="result_title">
                <h3>快捷操作</h3>
            </div>
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/category/create')}}"><i class="fa fa-plus"></i>添加分类</a>
                    <a class="all" href="javascript:;" onclick="checkAll(this);"><i class="fa fa-refresh"></i><span>全选</span></a>
                    <a href="{{URL::action('Admin\CategoryController@postDel')}}" class="del btndel" ><i class="fa fa-recycle"></i>批量删除</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th>选择</th>
                        <th class="tc">排序</th>
                        <th class="tc">ID</th>
                        <th>分类名称</th>
                        <th>标题</th>
                        <th>分类描述</th>
                        <th>查看次数</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $key => $v)
                    <tr>
                        <th align="center">
                                <span class="checkall" style="vertical-align:middle;">
									{{Form::checkbox('id[]',$v['cate_id'],null)}}
                                </span>
                        </th>
                        <td class="tc">
                            {{--排序: 需要参数 本身框位置,id值--}}
                            <input type="text" name="ord[]" onchange="changeOrder(this,{{$v->cate_id}})" value="{{$v->cate_order}}" >
                        </td>
                        <td class="tc">{{$v->cate_id}}</td>
                        <td>
                            <a href="#">
                                <?php //echo str_repeat('-',(5*$v->level)) ?>
                                    {!! $v->cate_name !!}
                            </a>
                        </td>
                        <td>{{$v->cate_title}}</td>
                        <td>{{str_limit($v->cate_discription,18)}}</td>
                        <td>{{$v->cate_view}}</td>
                        <td>
                            <a href="{{url('admin/category/'.$v->cate_id.'/edit')}}">修改</a>
                            <a href="javascript:void(0)" onclick="delCate({{$v->cate_id}})">删除</a>
                        </td>
                    </tr>
                        @endforeach
                </table>
                <div class="page_list">
                    <div>
                        {{$data->appends(['cate_id'=>Request::get('cate_id'),
                                          'keywords'=>Request::get('keywords')
                                         ])->links()}}
                        <br /><span class="rows">{{$count}} </span>
                    </div>
                </div>
            {{Form::close()}}
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
        function delCate(cate_id){
            layer.confirm('您确定要删除这个分类吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                //alert(cate_id);
                $.post('{{url('admin/category')}}/'+cate_id,{'_method':'delete','_token':"{{csrf_token()}}"},function(data){
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
    </script>

@endsection
