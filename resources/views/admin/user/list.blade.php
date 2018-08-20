@extends('layout.admin',['title' => '用户列表'])

<?php
use App\Lib\User as LibUser;
?>

@section('content')
<table class="table ">
    <tr>
        <th>ID</th>
        <th>账号</th>
        <th>名称</th>
        <th>权限</th>
        <th>创建时间</th>
        <th>更新时间</th>
        <th>操作</th>
    </tr>
    @if(count($data)>0)
        @foreach($data as $d)
        <tr>
            <td>{{$d['id']}}</td>
            <td>{{$d['user']}}</td>
            <td>{{$d['name']}}</td>
            <td>{{LibUser::GetReadablePermissions($d['permission'])}}</td>
            <td>{{$d['created_at']}}</td>
            <td>{{$d['updated_at']}}</td>
            <td>
                <a href="{{url('admin/user/'.$d['id'].'/edit')}}">修改</a>
                &nbsp;
                <a href="javascript:;" onclick="Delete({{$d['id']}});" >删除</a>
            </td>
        </tr>
        @endforeach
    @else 
    <tr><td colspan="7">木有数据</td></tr>
    @endif
</table>
@endsection

@push('script')
function Delete(id){
    // href="{{url('admin/user/'.$d['id'].'/edit')}}"
    if(confirm('确定删除? id='+id)){
        $.post('{{url("admin/user")}}/'+id,{
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