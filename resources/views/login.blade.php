@extends('master')
@include('component.loading')
@section('title')
    <title>用户登录</title>
@endsection
@section('content')
    <div class="weui_cells_title"></div>
    <div class="weui_cells weui_cells_form">
        <div class="weui_cell">
            <div class="weui_cell_hd"><label class="weui_label">帐号</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input class="weui_input" type="text" name = 'username'  placeholder="邮箱或手机号"/>
            </div>
        </div>
        <div class="weui_cell">
            <div class="weui_cell_hd"><label class="weui_label">密码</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input class="weui_input" type="password" name="password" placeholder="不少于6位"/>
            </div>
        </div>
        <div class="weui_cell weui_vcode">
            <div class="weui_cell_hd"><label class="weui_label">验证码</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input class="weui_input" type="text" name=validate_code placeholder="请输入验证码"/>
            </div>
            <div class="weui_cell_ft">
                <img src="{{route('validateCode')}}" class="bk_validate_code"/>
            </div>
        </div>
    </div>
    <div class="weui_cells_tips"></div>
    <div class="weui_btn_area">
        <a class="weui_btn weui_btn_primary" href="javascript:" onclick="onLoginClick();">登录</a>
    </div>
    <a href="{{route('register')}}" class="bk_bottom_tips bk_important">没有帐号? 去注册</a>
@endsection
@section('my-js')
    <script type="text/javascript">
        $('.bk_validate_code').click(function () {
            $(this).attr('src', '{{route('validateCode')}}?random=' + Math.random());
        });

        function onLoginClick() {
            //获取账号
            var username = $('input[name=username]').val();
            if (username.length == 0){
                $('.bk_toptips').show();
                $('.bk_toptips span').html('账号不能为空');
                setTimeout(function() {$('.bk_toptips').hide();}, 2000);
                return;
            }
            if (username.indexOf('@') == -1 ){ //账号是手机号
                if(username.length != 11 || username[0] != 1){
                    $('.bk_toptips').show();
                    $('.bk_toptips span').html('手机账号格式不对');
                    setTimeout(function() {$('.bk_toptips').hide();}, 2000);
                    return;
                }
            }else{
                //邮箱账号
                if (username.indexOf('.') == -1){
                    $('.bk_toptips').show();
                    $('.bk_toptips span').html('邮箱格式不对');
                    setTimeout(function() {$('.bk_toptips').hide();}, 2000);
                    return;
                }
            }
            //密码
            var password = $('input[name=password]').val();
            if(password.length == 0 || password.length < 6){
                $('.bk_toptips').show();
                $('.bk_toptips span').html('密码不能为空长度不能少于6位');
                setTimeout(function() {$('.bk_toptips').hide();}, 2000);
                return;
            }
            //验证码
            var validate_code = $('input[name=validate_code]').val();
            if (validate_code.length ==0 || validate_code.length < 4 ){
                $('.bk_toptips').show();
                $('.bk_toptips span').html('验证码不能为空长度不能小于4位');
                setTimeout(function() {$('.bk_toptips').hide();}, 2000);
                return;
            }
            //用ajxa注册
            $.ajax({
                type: "POST",
                url: '{{route('slogin')}}',
                dataType: 'json',
                cache: false,
                data: {username:username,password:password,validate_code:validate_code,_token:"{{csrf_token()}}"},
                success: function(data) {
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
                    //信息的代码等0时候登录成功
                    $('.bk_toptips').show();
                    $('.bk_toptips span').html(data.message);
                    setTimeout(function() {$('.bk_toptips').hide();}, 6000);
                    //登录成功跳转
                   //判断是否有值
                    if ('{{$return_url}}'){
                        location.href = "{{$return_url}}";
                    }else{
                        location.href = '{{route('category')}}';
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