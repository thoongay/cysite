@extends('layout.admin',['title' => '修改用户信息'])

<?php
use App\Lib\User as LibUser;
$perms=LibUser::GetAllPermissions();
$permStrLen=LibUser::GetPermisionStrLen();
?>

@section('content')
@include('component.errormsg',['errors'=>$errors])
<form action="{{url('admin/user/'.$data['id'])}}" method="post">
    <input type="hidden" value="put" name="_method">
    {{csrf_field()}}
    <table class="table ">
        <tr>
            <td>账号</td>
            <td><input type="text" name="user" value="{{$data['user']}}"></td>
        </tr>
        <tr>
            <td>名称</td>
            <td><input type="text" name="name" value="{{$data['name']}}"></td>
        </tr>
        <tr>
            <td>密码</td>
            <td><input type="password" name="password" ></td>
        </tr>
        <tr>
            <td>权限</td>
            <td>
                @foreach($perms as $key=>$index)
                    <input type="checkbox" name="permissions[]" value="{{$key}}"
                    @if($data['permission'][$index]=='1')
                        checked
                    @endif
                    >{{$key}}&nbsp;
                @endforeach
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
