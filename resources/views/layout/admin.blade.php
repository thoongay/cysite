@extends('layout.html',['title'=>'Login'])
{{-- @include('component.app') --}}

<?php
use App\Lib\User;
$permStr=session('perm');
$userMgr=User::VerifyPermissions($permStr,['UserMgr']);
?>

@push('css')
<link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('css/metisMenu.min.css')}}" rel="stylesheet">
<link href="{{asset('css/startmin.css')}}" rel="stylesheet">
<link href="{{asset('css/font-awesome.min.css')}}" rel="stylesheet">
@endpush

@push('js')
<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/metisMenu.min.js')}}"></script>
<script src="{{asset('js/startmin.js')}}"></script>
@endpush

@section('body')
{{-- https://github.com/secondtruth/startmin --}}
<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Startmin</a>
        </div>

        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>

        <!-- Top Navigation: Left Menu -->
        <ul class="nav navbar-nav navbar-left navbar-top-links">
            <li><a href="{{url('/')}}"><i class="fa fa-home fa-fw"></i> 主页</a></li>
        </ul>

        <!-- Top Navigation: Right Menu -->
        <ul class="nav navbar-right navbar-top-links">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i>
                    @if(Session('name'))
                        {{Session('name')}}
                    @else
                        匿名
                    @endif
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li>
                        <a href="#"><i class="fa fa-user fa-fw"></i> 修改密码</a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="{{url('admin/logout')}}"><i class="fa fa-sign-out fa-fw"></i> 退出登录</a>
                    </li>
                </ul>
            </li>
        </ul>

        <!-- Sidebar -->
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li>
                        <a href="{{url('admin/info')}}" class="active"><i class="fa fa-dashboard fa-fw"></i> 系统信息</a>
                    </li>
                    @if($userMgr)
                    <li>
                        <a href="#"><i class="fa fa-sitemap fa-fw"></i> 用户管理<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{{url('admin/user/')}}">用户列表</a>
                            </li>
                            <li>
                                <a href="#">添加用户</a>
                            </li>
                        </ul>
                    </li>
                    @endif
                    <li>
                        <a href="#"><i class="fa fa-sitemap fa-fw"></i> Multi-Level Dropdown<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="#">Second Level Item</a>
                            </li>
                            <li>
                                <a href="#">Third Level <span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li>
                                        <a href="#">Third Level Item</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>

            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header" style="font-size:24px;">{{$title or '无标题'}}</h1>
                </div>
            </div>

            <!-- ... Your content goes here ... -->
            @yield('content')

        </div>
    </div>

</div>
    
@endsection