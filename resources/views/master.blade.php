<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    @yield('title')
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,viewport-fit=cover">
    <link rel="stylesheet" href="{{asset('css/weui.css')}}">
    <link rel="stylesheet" href="{{asset('css/book.css')}}">
</head>
<body>
<div class="bk_title_bar">
    <img src="{{asset('images/back.png')}}" class="bk_back" alt="" onclick="history.go(-1);">
    <p class="bk_title_content"></p>
    <img src="{{asset('images/menu.png')}}" class="bk_menu" alt="" onclick="onMenuClick();">
</div>
<div class="page">
    @yield('content')
</div>

<!-- tooltips手机tooltips -->
<div class="bk_toptips"><span></span></div>

{{--<div id="global_menu" onclick="onMenuClick();">--}}
    {{--<div></div>--}}
{{--</div>--}}

<!--BEGIN actionSheet导航-->
<div id="actionSheet_wrap">
    <div class="weui_mask_transition" id="mask"></div>
    <div class="weui_actionsheet" id="weui_actionsheet">
        <div class="weui_actionsheet_menu">
            <div class="weui_actionsheet_cell" onclick="onMenuItemClick(1)">主页</div>
            <div class="weui_actionsheet_cell" onclick="onMenuItemClick(2)">产品类别</div>
            <div class="weui_actionsheet_cell" onclick="onMenuItemClick(3)">购物车</div>
            <div class="weui_actionsheet_cell" onclick="onMenuItemClick(4)">我的订单</div>
        </div>
        <div class="weui_actionsheet_action">
            <div class="weui_actionsheet_cell" id="actionsheet_cancel">取消</div>
        </div>
    </div>
</div>

</body>
<script type="text/javascript" src="{{asset('js/jquery-1.11.2.min.js')}}"></script>
@yield('my-js')
<script type="text/javascript">
    //标题document.title获取当前页面的标题
    $('.bk_title_content').html(document.title);
    //导航
    function hideActionSheet(weuiActionsheet, mask) {
        weuiActionsheet.removeClass('weui_actionsheet_toggle');
        mask.removeClass('weui_fade_toggle');
        weuiActionsheet.on('transitionend', function () {
            mask.hide();
        }).on('webkitTransitionEnd', function () {
            mask.hide();
        })
    }
    function onMenuClick () {
        var mask = $('#mask');
        var weuiActionsheet = $('#weui_actionsheet');
        weuiActionsheet.addClass('weui_actionsheet_toggle');
        mask.show().addClass('weui_fade_toggle').click(function () {
            hideActionSheet(weuiActionsheet, mask);
        });
        $('#actionsheet_cancel').click(function () {
            hideActionSheet(weuiActionsheet, mask);
        });
        weuiActionsheet.unbind('transitionend').unbind('webkitTransitionEnd');
    }
    function onMenuItemClick(index) {
        var mask = $('#mask');
        var weuiActionsheet = $('#weui_actionsheet');
        hideActionSheet(weuiActionsheet, mask);
        if(index == 1) {
            $('.bk_toptips').show();
            $('.bk_toptips span').html("敬请期待!");
            setTimeout(function() {$('.bk_toptips').hide();}, 2000);
        } else if(index == 2) {
            location.href = "{{route('category')}}";
        } else if(index == 3){
            location.href = "{{url('cart')}}";
        } else {
            location.href = "{{url('order_list')}}";
        }
    }
</script>
</html>