@extends('layout.admin',['pageTitle'=>'管理 - 配置管理', 'title' => '网站配置'])

<?php
use App\Lib\User as LibUser;
?>

@section('content')
@include('component.errormsg',['errors'=>$errors])
<form action="{{url('admin/setting/modify')}}" method="post">
    {{csrf_field()}}
    <table class="table ">
        <tr>
            <th>配置名</th>
            <th>描述</th>
            <th>内容</th>
        </tr>
        @foreach($data as $d)
        <tr>
            <td>{{$d['name']}}</td>
            <td>{{$d['description']}}</td>
            <td>@include('component.setting',[
                'type'=>$d['type'],
                'name' =>$d['name'],
                'content'=>$d['content'],
                'option' =>$d['option'], ])</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="2">
                <button type="submit" class="btn btn-primary">提交</button>
                <input type="button" value="发布" onclick="publish()" class="btn btn-warning">
            </td>
        </tr>     
    </table>
</form>
@endsection

@push('script')
function publish(){
    if(confirm('确定发布?')){
        $.post('{{url("admin/setting/publish")}}',{
            '_token':"{{csrf_token()}}"
        },function(data){
            alert(data.msg);
        });
    }
}
@endpush