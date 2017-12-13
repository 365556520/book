@extends('master')
@include('component.loading')
@section('title')
    <title>商品分类</title>
@endsection
@section('content')
    <div class="weui_cells_title">商品分类</div>
    <div class="weui_cells weui_cells_split">
        <div class="weui_cell weui_cell_select">
            <div class="weui_cell_bd weui_cell_primary">
                <select class="weui_select" name="category">
                    @foreach($categorys as $category)
                        <option value="{{$category->category_id}}">{{$category->category_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

{{--二级类别--}}
    <div class="weui_cells weui_cells_access">
    </div>

@endsection
@section('my-js')
    <script>
        _getCatefory();
        $('.weui_select').change(function (event) {
            _getCatefory();
        });
        function _getCatefory() {
            var parent_id = $('.weui_select option:selected').val();
            $.ajax({
                type: "get",
                url: '/service/getCategoryByParentId/'+parent_id,
                dataType: 'json',
                cache: false,
                success: function (data) {
                    if(data == null){
                        $('.bk_toptips').show();
                        $('.bk_toptips span').html("服务端错误");
                        setTimeout(function() {$('.bk_toptips').hide();}, 3000);
                        return;
                    }
                    if(data.status != 0){
                        $('.bk_toptips').show();
                        $('.bk_toptips span').html(data.message);
                        setTimeout(function() {$('.bk_toptips').hide();}, 3000);
                        return;
                    }
                    $('.weui_cells_access').html('');
                    //打印
                    console.log(data.categorys);
                    for (var i =0;i<data.categorys.length;i++){
                        var node =  '<a class="weui_cell" href="javascript:;">' +
                                        '<div class="weui_cell_bd weui_cell_primary">' +
                                            '<p>'+data.categorys[i].category_name +'</p>' +
                                        '</div>' +
                                        '<div class="weui_cell_ft">说明文字</div>' +
                                    '</a>';
                        $('.weui_cells_access').append(node);
                    }

                },
                error: function (xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                }
            });
        }
    </script>
@endsection