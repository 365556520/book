@extends('master')
@include('component.loading')
@section('title')
    <title>{{$product_name}}</title>
@endsection
@section('content')
        <div class="weui_cells weui_cells_access ">
            {{--//产品列表--}}
        @foreach($products as $product)
            <a class="weui_cell" href="javascript:;">
                <div class="weui_cell_hd"><img src="{{$product->product_preview}}" class="bk_preview"></div>
                <div class="weui_cell_hd weui_cell_primary">
                 <div  class="bk_title_bot">
                     <span class="bk_title">{{$product->product_name}}</span>
                     <div class="bk_price_ft">￥{{$product->product_price}}</div>
                 </div>
                    <p class="bk_summary  weui_cell_ft">{{$product->product_summary}}</p>
                </div>
            </a>
        @endforeach
        </div>
    </div>
@endsection
@section('my-js')

@endsection