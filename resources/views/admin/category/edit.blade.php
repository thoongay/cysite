@extends('layout.admin',['title' => '修改分类信息'])

<?php
use App\Lib\User as LibUser;
?>

@section('content')
@include('component.errormsg',['errors'=>$errors])
<form action="{{url('admin/category/'.$data['id'])}}" method="post">
    <input type="hidden" value="put" name="_method">
    {{csrf_field()}}
    <table class="table ">
        <tr>
            <td>分类名</td>
            <td><input type="text" name="name" value="{{$data['name']}}"></td>
        </tr>
        <tr>
            <td>描述</td>
            <td><input type="text" name="description" value="{{$data['description']}}"></td>
        </tr>
        <tr>
            <td colspan="2">
                <button type="submit" class="btn btn-primary">提交</button>
            </td>
        </tr>     
    </table>
</form>
@endsection
