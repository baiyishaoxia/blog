1、get提交
$("button").click(function(){
  $.get("demo_test.php",function(data,status){
    alert("数据: " + data + "\n状态: " + status);
  });
});


2、post提交
$("button").click(function(){
    $.post("/try/ajax/demo_test_post.php",
    {
        name:"菜鸟教程",
        url:"http://www.runoob.com"
    },
        function(data,status){
        alert("数据: \n" + data + "\n状态: " + status);
    });
});



3、针对于某个表单按钮post提交 表单id='form' 按钮class='formbotton'
$(function(){
  $(".formbotton").click(function(){
       var url = $("#form").attr('url');
	   var data = $("#form").serialize();
	   $.ajaxSetup({
	       headers:{'X-CSRF-TOKEN':'{{csrf_token()}}'}
	   });
	   $.ajax({
	       url:url,
		   type:"POST",
		   data:data,
		   success:function(data){
		         if(data.code == '201'){
				       alert(data.msg);
				 }else{
				       alert(data.msg);
					   window.setTimeout(function(){
					     window.localtion.href = data.url;
					   }，1000);
				 }
		   }
	   })
  })
});


4、针对于某个input[type='text']框值发生改变使用 'onchange'=>"changeOrder(this,$val->id)"] 进行post提交异步排序
<input type="text" name="ord[]" onchange="changeOrder(this,{{$v->cate_id}})" value="{{$v->cate_order}}" >
<script>
	//排序更新动作
	function changeOrder(obj,id){
		var sort = $(obj).val();
		$.post("{{url('admin/article1/changeOrder')}}",{'_token': "{{csrf_token()}}",'id':id,'sort': sort },function(data){
			if(data.status == 0){
				layer.msg(data.msg, {icon: 6});
				sleep(3000);
				location.reload();
			}else{
				layer.msg(data.msg, {icon: 5});
			}
		});
	}
</script>
public function changeOrder()
{
  $input = Input::all();
  $cate = Category::find($input['cate_id']);
  $cate->cate_order = $input['cate_order'];
  $re = $cate->update();
  if($re){
	  $data = [
		   'status'=>0,
		   'msg'=> '分类排序更新成功!',
	  ];
  }else{
	  $data = [
		  'status'=>1,
		  'msg'=> '分类排序更新失败,请稍后重试!',
	  ];
  }
  return $data;
}

5、当select选项发生改变时get提交，例如['0'=>'中文','1'=>'英文']  class='is_language'
<script type="text/javascript">
	$('.is_language').change(function () {
		var the_form=$(this).parents('form').eq(0);
		the_form.attr('method','get');
		the_form.submit();
	})
</script>

6、全选
<li><a class="all" href="javascript:;" onclick="checkAll(this);"><i></i><span>全选</span></a></li>
<span class="checkall" style="vertical-align:middle;">{{Form::checkbox('id[]',$val->id,null)}}</span>
<script>
//全选取消按钮函数
function checkAll(chkobj) {
    if ($(chkobj).text() == "全选") {
        $(chkobj).children("span").text("取消");
        $(".checkall input:enabled").prop("checked", true);
    } else {
        $(chkobj).children("span").text("全选");
        $(".checkall input:enabled").prop("checked", false);
    }
}
</script>

7、laravel中的删除delete方式删除(其中url('admin/article')是路由Route::resource加载的别名，对应控制器将自动调用destroy($art_id)方法)
 <a href="javascript:void(0)" onclick="delArt({{$v->art_id}})">删除</a>
 <script>
	function delArt(art_id) {
		layer.confirm('您确定要删除这篇文章吗？', {
			btn: ['确定','取消'] //按钮
		}, function(){
			$.post('{{url('admin/article')}}/'+art_id,{'_method':'delete','_token':"{{csrf_token()}}"},function(data){
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
public function destroy($art_id)
{
	$re = Article::where('art_id',$art_id)->delete();
	if($re){
		$data = [
			'status'=>0,
			'msg'  =>'恭喜,文章删除成功!',
		];
	}else{
		$data = [
			'status'=>1,
			'msg'  =>'抱歉,文章删除失败,请稍后重试!',
		];
	}
	return $data;
}

8、laravel中Route::resource的处理修改put方式提交，形如admin.article.{参数}，将自动调用 update($art_id)方法
视图：  <form action="{{url('admin/article').'/'.$filed->art_id}}" method="post">
控制器：public function update($art_id)
		 {
		   $input = Input::except('_token','_method');
		   $rules = [
				'name值' =>'required',
			];
		   $message = [
				'name值.required' =>'文章标题不能为空!',
			];
		   $validator = \Validator::make($input,$rules,$message);
		   if($validator->passes()) {
			   $re = Article::where('art_id',$art_id)->update($input);
			   if ($re) {
				   return redirect('admin/article');
			   } else {
				   return back()->withInput()->withErrors('数据更改失败！');
			   }
		   }return back()->withInput()->withErrors($validator);
		 }
		 
9、删除（配合全选使用）
<li><a href="{{URL::action('Admin\CategoryController@delAll')}}" class="del btndel" ><i></i><span>删除</span></a></li>
<span class="checkall" style="vertical-align:middle;">{{Form::checkbox('id[]',$val->id,null)}}</span>
//region 列表页删除选中的ID
    $('.btndel').each(function () {
        var href = $(this).attr('href');
        $(this).attr('href','javascript:void(0)');
        $(this).attr('url',href);
    });
    $('.btndel').click(function () {
        if ($(".checkall input:checked").size() < 1) {
            parent.dialog({
                title: '提示',
                content: '对不起，请选中您要操作的记录！',
                okValue: '确定',
                ok: function () { }
            }).showModal();
            return false;
        }
        var msg = "删除记录后不可恢复，您确定吗？";
        if (arguments.length == 2) {
            msg = objmsg;
        }
        var obj=this;
        parent.dialog({
            title: '提示',
            content: msg,
            okValue: '确定',
            ok: function () {
                var action=$(obj).attr('url');
                $(obj).parents('form').eq(0).attr('action',action);
                $(obj).parents('form').append('<input name="_method" type="hidden" value="DELETE">');
                $(obj).parents('form').eq(0).submit();
            },
            cancelValue: '取消',
            cancel: function () { }
        }).showModal();
        return false;
    });
//endregion





