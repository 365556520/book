<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,viewport-fit=cover">
    <link rel="stylesheet" href="{{asset('css/weui.css')}}">
    <link rel="stylesheet" href="{{asset('css/book.css')}}">
</head>
<body>

<div class="page">

    @yield('content')
</div>

</body>
<script type="text/javascript" src="{{asset('js/jquery-1.11.2.min.js')}}"></script>

</html>