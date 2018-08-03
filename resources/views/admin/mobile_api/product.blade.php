@extends('layouts.master')

@section('title','图书列表')

@section('content')
    <div class="weui_cells_title">选择书籍</div>
    <div class="weui_cells weui_cells_access">
        @foreach($products as $key => $val)
         <a class="weui_cell" href="{{URL::action('Admin\MobileApi\CategoryController@getProductContent',['product_id'=>$val->art_id])}}">
            <div class="weui_cells_hd"><img class="bk_preview" src="{{Storage::url($val->art_thumb)}}" alt=""></div>
                <div class="weui_cell_bd weui_cell_primary">
                    <div style="margin-bottom: 10px;">
                        <span class="bk_title">{{$val->art_title}}</span>
                        <span class="bk_price" style="float: right">${{$val->art_order}}</span>
                    </div>
                    <p class="bk_summary">{{$val->art_discription}}</p>
                 </div>
             <div class="weui_cell_ft"></div>
         </a>
        @endforeach
    </div>
@endsection

@section('my-js')

@endsection