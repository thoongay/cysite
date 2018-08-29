@extends('layout.admin',['pageTitle'=>'管理 - 配置管理', 'title' => '修改配置'])

<?php
use App\Lib\User as LibUser;
?>

@push('script')

var defOption=$('#default-option');

function SelectChanged(obj){
    defOption.css('display', obj.value=="checkbox"?'table-row':'none');
}

SelectChanged($('[name="type"]'));
@endpush

@section('content')
@include('component.errormsg',['errors'=>$errors])
<form action="{{url('admin/setting/'.$data['id'])}}" method="post">
    <input type="hidden" value="put" name="_method">
    {{csrf_field()}}
    <table class="table ">
        <tr>
            <td>配置名</td>
            <td><input type="text" name="name" value="{{$data['name']}}"></td>
        </tr>
        <tr>
            <td>描述</td>
            <td><input type="text" name="description" value="{{$data['description']}}"></td>
        </tr>
        <tr>
            <td>类型</td>
            <td><select name="type" onchange="SelectChanged(this);">
                @foreach($optionTypes as $type)
                    <option value="{{$type}}" 
                        @if($data['type']===$type)
                            selected="selected"    
                        @endif
                    >{{$type}}</option> 
                @endforeach
            </select></td>
        </tr>
        <tr id="default-option">
            <td>默认选项</td>
            <td><input type="text" name="option" placeholder="item1,item2, ... "
                value="{{$data['option']}}"></td>
        </tr>
        <tr>
            <td colspan="2">
                <button type="submit" class="btn btn-primary">提交</button>
            </td>
        </tr>     
    </table>
</form>
@endsection
