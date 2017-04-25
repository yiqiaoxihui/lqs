<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="_token" content="{{ csrf_token() }}"/>
    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="{{asset('font-awesome/css/font-awesome.css')}}" >

    <!-- Styles -->
    <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('datejs/bootstrap-datetimepicker.min.css')}}">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    <style>
        body {
            font-family: "Helvetica Neue", Helvetica, Microsoft Yahei, Hiragino Sans GB, WenQuanYi Micro Hei, sans-serif;
        }

        .fa-btn {
            margin-right: 6px;
        }
        .table-outline{
            /*height: 400px;*/
            margin-left: 20px;
            margin-right: 20px;
            margin-top: 20px;
            border:1px solid;
            border-radius: 10px;
            text-align: center;
        }
        th{
          text-align: center;
        }
        table{
          marginleft:50px;text-align: center;
        }
        h2{
          text-align: center;
        }
        input{
          text-align: center;
        }
        .menu{
          font-size: 19px;
        }
        .navbar-brand{
          font-size: 20px;
          font-weight: bold;
        }
        ul li ul li{
          margin: 5px;
          font-size: 16px;
        }

    </style>
</head>
<body id="app-layout">
<nav class="navbar navbar-default" role="navigation">
   <div class="navbar-header">
      <a class="navbar-brand" href="{{url("admin")}}">DETECT SYSTEM后台管理</a>
   </div>
   <div class="menu">
      <ul class="nav navbar-nav">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
               节点管理
               <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
              <li><a href="{{url("admin")}}">节点管理</a></li>
              <!-- <li><a href="{{url("admin/ykNumber")}}">游客数量走势图</a></li>
              <li><a href="{{url("admin/ykType")}}">游客类型分析</a></li>
              <li><a href="{{url("admin/ykSource")}}">游客客源地分析</a></li> -->
            </ul>
         </li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
               虚拟机管理 
               <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
               <li><a href="{{url("image/base")}}">原始镜像</a></li>
               <li><a href="{{url("image/overlay")}}">增量镜像</a></li>
            </ul>
         </li>
         <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
               文件管理 
               <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
               <li><a href="{{url("file/fileInfo")}}">文件管理</a></li>
               <!-- <li><a href="{{url("incomeAnalyze/incomeSum")}}">总收入统计</a></li>
               <li><a href="{{url("incomeAnalyze/incomeAccumulate")}}">收入累计</a></li> -->
            </ul>
         </li>
         <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
               用户管理 
               <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
               <li><a href="{{url("user/userInfo")}}">用户管理</a></li>
            </ul>
         </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
          @if (Auth::guest())
            <li><a href="{{ url('/auth/login') }}">Login</a></li>
            <li><a href="{{ url('/auth/register') }}">Register</a></li>
          @else
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="{{ url('/auth/logout') }}">Logout</a></li>
              </ul>
            </li>
          @endif
        </ul>
   </div>
</nav>
@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <div class="container-fluid">
      @yield('content')
    </div>
    

    <!-- JavaScripts -->
    <script src="{{asset('jquery/jquery.min.js')}}"></script>
    <script src="{{asset('bootstrap/js/bootstrap.js')}}"></script>
    <script src="{{asset('Highcharts/js/highcharts.js')}}"></script> 
    <script src="{{asset('Highcharts/exporting.js')}}"></script>   
    <script src="{{asset('datejs/bootstrap-datetimepicker.js')}}"></script>
    <script src="{{asset('layer/layer.js')}}"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
</body>
</html>
<script type="text/javascript">
/*********************近七日游客走势图**************************/
$('#datetimepicker').datetimepicker({
    format: 'yyyy-mm-dd',
    minView:'month',
    todayBtn: true,
    autoclose: true
});
$('#ydate').datetimepicker({
    format: 'yyyy-mm-dd',
    minView:'month',
    autoclose: true
});
/*********************游客数量走势图**************************/
$('#ykNumberDate').datetimepicker({
    format: 'yyyy-mm-dd',
    minView:'month',
    todayBtn: true,
    autoclose: true
});
/*********************景区游客**************************/
$('#spotsYkDate').datetimepicker({
    format: 'yyyy-mm-dd',
    minView:'month',
    todayBtn: true,
    autoclose: true
});

</script>
