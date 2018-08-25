@extends('layout.admin',['pageTitle'=>'管理 - 配置管理', 'title' => '添加配置项'])

<?php
use App\Lib\User as LibUser;
?>

@push('style')
.pagination{
    margin:0px;
}    
@endpush

@section('content')
<table class="table ">
    <tr>
        <th>ID</th>
        <th>名称</th>
        <th>类型</th>
        <th>操作</th>
    </tr>
    @if(count($data)>0)
        @foreach($data as $d)
        <tr>
            <td>{{$d['id']}}</td>
            <td>{{$d['name']}}</td>
            <td>{{$d['type']}}</td>
            <td>
                <a href="{{url('admin/setting/'.$d['id'].'/edit')}}">修改</a>
                &nbsp;
                <a href="javascript:;" onclick="Delete({{$d['id']}},'{{$d['name']}}');" >删除</a>
            </td>
        </tr>
        @endforeach
    @else 
    <tr><td colspan="7">木有数据</td></tr>
    @endif
</table>
@endsection

@push('script')
function Delete(id,title){
    if(confirm('确定删除?\n'+id+'.'+title)){
        $.post('{{url("admin/setting")}}/'+id,{
            '_method':'delete',
            '_token':"{{csrf_token()}}"
        },function(data){
            if(data.status){
                location.href=location.href;
            }else{
                alert(data.msg);
            }
        });
    }
}
@endpush