@extends('layout.admin',['title' => '文章列表'])

<?php
use App\Lib\User as LibUser;
?>

@section('content')
{{$data->links()}}
<table class="table ">
    <tr>
        <th>ID</th>
        <th width="60%">标题</th>
        <th>作者</th>
        <th>操作</th>
    </tr>
    @if(count($data)>0)
        @foreach($data as $d)
        <tr>
            <td>{{$d['id']}}</td>
            <td>{{$d['title']}}</td>
            <td>
                @if(array_key_exists($d['author'],$names))
                    {{$names[$d['author']]}}
                @else 
                    无名
                @endif
            </td>
            <td>
                <a href="{{url('admin/article/'.$d['id'].'/edit')}}">修改</a>
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
        $.post('{{url("admin/article")}}/'+id,{
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