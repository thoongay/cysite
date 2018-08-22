@extends('layout.admin',['title' => '添加文章'])

<?php
use App\Lib\User as LibUser;
?>

@include('vendor.ueditor.assets')

@push('script')
    var ue = UE.getEditor('container');
    ue.ready(function() {
        ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
    });

    $("#formArticle").submit( function(eventObj) {
        $('#plainText').val(ue.getContentTxt());
        return true;
    });
@endpush    <!-- 实例化编辑器 -->

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
<form action="{{url('admin/article')}}" method="post" id="formArticle">
    {{csrf_field()}}
    <input type="hidden" name="mark" value="{{$mark}}">
    <input type="hidden" name="text" value="" id="plainText">
    <table class="table ">
        <tr>
            <td colspan="2">
                <input type="text" name="title" placeholder="标题" class="full-width"
                    value="{{$title or ''}}">
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <!-- 加载编辑器的容器 -->
                <script id="container" name="content" type="text/plain" class="min-heigh"
                >@if(isset($content)){!! $content !!}@endif</script>
            </td>
        </tr>
        <tr>
            <td width="40%">分类:
                <select name="category">
                    @foreach($cates as $index=>$cate)
                        <option value="{{$index}}" 
                            @if(isset($category))
                                @if($category==$index)
                                    selected
                                @endif
                            @endif
                        >{{$cate}}</option> 
                    @endforeach
                </select>
            </td>
            <td width="60%">
                <input type="text" name="keyword" placeholder="关键词" class="full-width" 
                    value="{{$keyword or ''}}">
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <button type="submit" class="btn btn-primary">提交</button>
            </td>
        </tr>
    </table>
</form>
@endsection
