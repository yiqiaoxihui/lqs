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
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

<style>
    body {
        font-family: "Helvetica Neue", Helvetica, Microsoft Yahei, Hiragino Sans GB, WenQuanYi Micro Hei, sans-serif;
    }
    .fa-btn {
        margin-right: 6px;
    }
    h2{
      text-align: center;
      }
    .yktypeline{
      text-align: center;
      font-size: 25px;
    }
    .navbar-brand{
      font-size: 20px;
      font-weight: bold;
    }
    ul li ul li{
      margin: 5px;
      font-size: 16px;
    }
    .menu{
      font-size: 19px;
    }
</style>
</head>
<body id="app-layout">
<nav class="navbar navbar-default" role="navigation">
   <div class="navbar-header">
      <a class="navbar-brand" href="/">旅游景区领导查询系统</a>
   </div>
   <div class="menu">
      <ul class="nav navbar-nav">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
               游客分析 
               <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
              <li><a href="{{url("yktrend")}}">当日游客数量统计</a></li>
               <li><a href="{{url("ykNumber")}}">游客数量走势图</a></li>
               <li><a href="{{url("ykType")}}">游客类型分析</a></li>
               <li><a href="{{url("ykSource")}}">游客客源地分析</a></li>
            </ul>
         </li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
               同期比
               <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
               <li><a href="{{url("pepCompare")}}">游客人数同期比</a></li>
               <li><a href="{{url("incomeCompare")}}">收入同期比</a></li>
            </ul>
         </li>
         <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
               收入分析 
               <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
               <li><a href="{{url("incomeSource")}}">收入来源分析</a></li>
               <li><a href="{{url("incomeSum")}}">总收入统计</a></li>
               <li><a href="{{url("incomeAccumulate")}}">收入累计</a></li>
            </ul>
         </li>
         <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
               景点客流
               <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
               <li><a href="{{url("spotsYk")}}">当日景点客流统计</a></li>
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


    @yield('content')

    <!-- JavaScripts -->
    <script src="{{asset('jquery/jquery.min.js')}}"></script>
    <script src="{{asset('bootstrap/js/bootstrap.js')}}"></script>
    <script src="{{asset('Highcharts/js/highcharts.js')}}"></script> 
    <script src="{{asset('Highcharts/exporting.js')}}"></script>   
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
</body>
</html>
