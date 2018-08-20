@extends('layout.admin',['title' => '添加用户'])

<?php
use App\Lib\User as LibUser;
$perms=LibUser::GetAllPermissions();
$permStrLen=LibUser::GetPermisionStrLen();
?>

@section('content')
@include('component.errormsg',['errors'=>$errors])
<form action="{{url('admin/user')}}" method="post">
    {{csrf_field()}}
    <table class="table ">
        <tr>
            <td>账号</td>
            <td><input type="text" name="user" ></td>
        </tr>
        <tr>
            <td>名称</td>
            <td><input type="text" name="name" ></td>
        </tr>
        <tr>
            <td>密码</td>
            <td><input type="password" name="password"></td>
        </tr>
        <tr>
            <td>确认密码</td>
            <td><input type="password" name="password_confirmation"></td>
        </tr>
        <tr>
            <td>权限</td>
            <td>
                @foreach($perms as $key=>$index)
                    <input type="checkbox" name="permissions[]" value="{{$key}}">{{$key}}&nbsp;
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
