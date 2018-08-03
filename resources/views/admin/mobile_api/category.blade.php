@extends('layouts.master')

@section('title','类别')

@section('content')
    <div class="weui_cells_title">选择类别</div>
    <div class="weui_cells weui_cells_split">
        <div class="weui_cells weui_cell_select" >
            <div class="weui_cell_bd weui_cell_primary">
                {{Form::select('cate_id',\App\Http\Model\Category::tree2(3),Request::get('cate_id'),['class'=>'weui_select'])}}
            </div>
        </div>
    </div>

    <div class="weui_cells weui_cells_access"></div>



@endsection

@section('my-js')
    <script>
        _getcategory();
        $('.weui_select').change(function (event) {
            _getcategory();
        });

        function  _getcategory() {
            var parent_id = $('.weui_select option:selected').val();
            console.log(parent_id);
            $.ajax({
                type: "GET",
                url:"{{URL::action('Admin\MobileApi\CategoryController@getInfo')}}"+'/'+parent_id,
                dataType:'json',
                cache:false,
                success: function(data) {
                    //console.log(data);
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
                    //console.log(data);
                    $('.weui_cells_access').html('');
                    for(var i=0;i<data.categorys.length; i++){
                        var next = '{{URL::action('Admin\MobileApi\CategoryController@getProduct')}}'+'/'+data.categorys[i].cate_id;
                        var node = '<a class="weui_cell" href="'+ next +'">'+
                                    '<div class="weui_cells_bd weui_cell_primary">'+
                                    '<p>'+ data.categorys[i].cate_name +'</p>'+
                                    '</div>'+
                                    '<div class="weui_cell_ft">'+ data.categorys[i].cate_title +'</div>'+
                                    '</a>';
                        $('.weui_cells_access').append(node);
                    }

                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                }
            });
        }

    </script>
@endsection