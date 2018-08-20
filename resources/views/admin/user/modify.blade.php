@extends('layout.admin',['title' => '修改密码'])

@section('content')
@include('component.errormsg',['errors'=>$errors])
<form action="{{url('admin/user/modify')}}" method="post">
    {{csrf_field()}}
    <table class="table ">
        <tr>
            <td>账号</td>
            <td>{{session('user')}}</td>
        </tr>
        <tr>
            <td>名称</td>
            <td>{{session('name')}}</td>
        </tr>
        <tr>
            <td>原密码</td>
            <td><input type="password" name="old_password"></td>
        </tr>
        <tr>
            <td>新密码</td>
            <td><input type="password" name="password"></td>
        </tr>
        <tr>
            <td>确认新密码</td>
            <td><input type="password" name="password_confirmation"></td>
        </tr>
        <tr>
            <td colspan="2">
                <button type="submit" class="btn btn-primary">提交</button>
            </td>
        </tr>     
    </table>
</form>
@endsection
