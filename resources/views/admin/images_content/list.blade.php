@extends('background.layouts.main')
@section('css')
	{{Html::style('admin/style/css/lightbox.min.css')}}
@endsection
@section('js')
    @include('background.layouts.btnsave')
	<script type="text/javascript">
		$('.channel_category_id').change(function () {
			var the_form=$(this).parents('form').eq(0);
			the_form.attr('method','get');
			the_form.submit();
		})
	</script>
@endsection
@section('content')
    {{Form::open()}}

   <!--导航栏-->
	<div class="location">
		<a href="javascript:history.back(-1);" class="back"><i></i><span>返回上一页</span></a>
		<a href="{{URL::action('Admin\IndexController@info')}}" class="home"><i></i><span>首页</span></a>
		<i class="arrow"></i>
		<span>图片列表</span>
	</div>
	<!--/导航栏-->

	<!--工具栏-->
	<div id="floatHead" class="toolbar-wrap">
		<div class="toolbar">
			<div class="box-wrap">
				<a class="menu-btn"></a>
				<div class="l-list">
					<ul class="icon-list">
						<li><a class="add" href="{{URL::action('Admin\ImagesContentController@getCreate')}}"><i></i><span>新增</span></a></li>
                        <li><a class="all" href="javascript:;" onclick="checkAll(this);"><i></i><span>全选</span></a></li>
						<li><a href="{{URL::action('Admin\ImagesContentController@postDel')}}" class="del btndel" ><i></i><span>删除</span></a></li>
					</ul>
				</div>
				<div class="r-list">
					<div class="rule-single-select">
						{{Form::select('ImgClass_Id',\App\Http\Model\Background\ImagesClass::tree(2),Request::get('ImgClass_Id'))}}
					</div>
					{{Form::text('keywords',Request::get('keywords',''),['class'=>'keyword'])}}
					<a class="btn-search" href="javascript:void (0)">查询</a>
				</div>
			</div>
		</div>
	</div>
	<!--/工具栏-->

	<!--列表-->
	<div class="table-container">
		<div class="photo-list">
			<ul>
				@foreach($data as $key => $val)
					<li>
						<div align="center">
                                <span class="checkall" style="vertical-align:middle;">
									{{Form::checkbox('id[]',$val['Id'],null)}}
                                </span>
						</div>
						<div class="img-box" onclick="setFocusImg(this);">
                            <?php
                                 $info= GetImageSize('storage\\'.$val['Icon']);
								 $val['Width']=$info['0'];
								 $val['Height']=$info['1'];
							     $width=floor($val['Width']*300/$val['Height']);
							?>
							<div class="item" data-w="{{$width}}" data-h="300">
								<a href="{{Storage::url($val->Icon)}}" data-lightbox="lbx" target="_blank" style="display: block" class="lightbox" >
									<img class="example-image" src="{{Storage::url($val->Icon)}}" bigsrc="{{Storage::url($val->path)}}">
								</a>
							</div>
						</div>
						<a href="javascript:void(0)" onclick="delCate({{$val->Id}})">删除</a>
					</li>
				@endforeach
			</ul>
		</div>
	</div>
	{{Form::close()}}
	<!--/列表-->
	<span class="page_total">共{{$data->total()}}条记录</span>
	{{$data->links()}}
@section('js')
{{Html::script('admin/style/js/lightbox-plus-jquery.min.js')}}
<script>
    function delCate(id){
        layer.confirm('您确定要删除这个照片吗？', {
            btn: ['确定','取消']
        }, function(){
            $.get('{{URL::action('Admin\ImagesContentController@del')}}',{'_method':'get','_token':"{{csrf_token()}}",'id':id},function(data){
                if(data.status == 0){
                    layer.msg(data.msg, {icon: 6});
                    location.reload();
                }else{
                    layer.msg(data.msg, {icon: 5});
                }
            });
    });
}
</script>
@endsection