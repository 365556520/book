@extends('master')
@include('component.loading')
@section('title')
    <title>{{$product->product_name}}</title>
    <link rel="stylesheet" href="{{asset('css/swipe.css')}}">
@endsection
@section('content')
    <div class="page bk_content" style="top: 0;">
        {{--轮播图--}}
        <div class="addWrap">
            <div class="swipe" id="mySwipe">
                <div class="swipe-wrap">
                    @foreach($pdt_images as $pdt_image)
                        <div>
                            <a href="javascript:;"><img class="img-responsive" src="{{url($pdt_image->image_path)}}" /></a>
                        </div>
                    @endforeach
                </div>
            </div>
            <ul id="position">
                @foreach($pdt_images as $index => $pdt_image)
                    <li class={{$index == 0 ? 'cur' : ''}}></li>
                @endforeach
            </ul>
        </div>
        {{--详情介绍和价钱--}}
        <div class="weui_cells_title ">
            <span class="bk_title">{{$product->product_name}}</span>
            <div class="bk_price_ft bk_title_bot">￥{{$product->product_price}}</div>
        </div>
        <div class="weui_cells">
            <div class="weui_cell">
                <p class="bk_summary bk_font">{{$product->product_summary}}</p>
            </div>
        </div>
        <div class="weui_cells_title ">详情介绍</div>
        <div class="weui_cells">
            <div class="weui_cell">
                <p class="bk_font">{{$pdt_content->content}}</p>
            </div>
        </div>
    </div>
    {{--添加购物车和结算--}}
    <div class="bk_fix_bottom">
        <div class="bk_half_area">
            <button class="weui_btn weui_btn_primary" onclick="">加入购物车</button>
        </div>
        <div class="bk_half_area">
            <button class="weui_btn weui_btn_default" onclick="">查看购物车(<span id="cart_num" class="m3_price"></span>)</button>
        </div>
    </div>
@endsection
@section('my-js')
    <script type="text/javascript" src="{{asset('js/swipe.min.js')}}"></script>
    <script type="text/javascript">
        //录播图JS
        var bullets = document.getElementById('position').getElementsByTagName('li');
        Swipe(document.getElementById('mySwipe'), {
            auto: 2000,
            continuous: true,
            disableScroll: false,
            callback: function(pos) {
                var i = bullets.length;
                while (i--) {
                    bullets[i].className = '';
                }
                bullets[pos].className = 'cur';
            }
        });
    </script>
@endsection