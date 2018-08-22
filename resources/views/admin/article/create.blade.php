@extends('layout.admin',['title' => '添加文章'])

<?php
use App\Lib\User as LibUser;
?>

@push('script')
    var ue = UE.getEditor('container');

    function SendData(){
        alert('submit');
    }
@endpush    <!-- 实例化编辑器 -->

@push('js')
<!-- 配置文件 -->
<script type="text/javascript" src="{{url('ueditor\ueditor.config.js')}}"></script>
<!-- 编辑器源码文件 -->
<script type="text/javascript" src="{{url('ueditor\ueditor.all.min.js')}}"></script>
@endpush

@push('style')
    .full-width{
        width: 100%
    }
    .min-heigh{
        min-height: 300px;
    }
@endpush

@section('content')
@include('component.errormsg',['errors'=>$errors])
<form action="{{url('admin/article')}}" method="post">
    {{csrf_field()}}
    <input type="hidden" name="image">
    <input type="hidden" name="mark" value="{{LibUser::GenToken(32)}}">
    <table class="table ">
        <tr>
            <td colspan="2"><input type="text" name="title" placeholder="标题" class="full-width"></td>
        </tr>
        <tr>
            <td colspan="2">
                <!-- 加载编辑器的容器 -->
                <script id="container" name="content" type="text/plain" class="min-heigh">
                </script>
            </td>
        </tr>
        <tr>
            <td width="40%">分类:
                <select name="category">
                    @foreach($cates as $index=>$cate)
                        <option value="{{$index}}">{{$cate}}</option> 
                    @endforeach
                </select>
            </td>
            <td width="60%">
                <input type="text" name="keyword" placeholder="关键词" class="full-width">
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="button" value="提交" onclick="SendData()" class="btn btn-primary">
            </td>
        </tr>
    </table>
</form>
@endsection
