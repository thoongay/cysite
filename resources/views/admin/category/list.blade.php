@extends('layout.admin',['title' => '分类列表'])

<?php
use App\Lib\User as LibUser;
?>

@section('content')
<table class="table ">
    <tr>
        <th>ID</th>
        <th>名称</th>
        <th>描述</th>
        <th>创建时间</th>
        <th>更新时间</th>
        <th>操作</th>
    </tr>
    @if(count($data)>0)
        @foreach($data as $d)
        <tr>
            <td>{{$d['id']}}</td>
            <td>{{$d['name']}}</td>
            <td>{{$d['description']}}</td>
            <td>{{$d['created_at']}}</td>
            <td>{{$d['updated_at']}}</td>
            <td>
                <a href="{{url('admin/category/'.$d['id'].'/edit')}}">修改</a>
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
function Delete(id,name){
    if(confirm('确定删除?\n'+id+'.'+name)){
        $.post('{{url("admin/category")}}/'+id,{
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