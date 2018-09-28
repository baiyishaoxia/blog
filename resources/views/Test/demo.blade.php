@extends('layouts.app')

@section('content')
<center>欢迎使用PHP-Laravel语言编程</center>
<!--/数据-->
<form action="{{URL::action('Home\TestController@GetTestList')}}" method="get" id="form1">
<table>
    <tr>
        <td width="5%">ID</td>
        <td width="8%">登录名</td>
        <td width="8%">用户名</td>
        <td width="8%">标题</td>
        <td width="8%">说明</td>
    </tr>
    @foreach($data as $key => $val)
    <tr>
        <td>{{$val->id}}</td>
        <td>{{$val->user_name}}</td>
        <td>{{$val->realname}}</td>
        <td>{{$val->title}}</td>
        <td>{{$val->remark}}</td>
    </tr>
     @endforeach
    <!--/分页-->
    <div class="page_list">
        <div>
            {{$data->links()}}
            <span class="rows">{{$count}} </span>
            <br />
        </div>
    </div>
</table>
</form>

@section('js')
    <script type="text/javascript">
        $(function(){
            //alert("这里写js");
        })
    </script>
@endsection
@endsection