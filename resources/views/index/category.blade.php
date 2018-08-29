@extends('layout.index.leftright')

@section('top')
    @include('component/cateListTop')
@endsection

@section('left')
<div class="category-box-main-div">
    <div class="category-box-cate-name">{{$cateName}}</div>
    @if($data!=null)
        {{$data->links()}}
        @foreach($data as $d)
        <div class="category-box-title-div">
            <a href="{{url('article/'.$d['id'])}}" title="{{$d['title']}}">{{$d['title']}}</a>
            <span>{{date('Y/M/d',$d['created_at']->timestamp)}}</span>
        </div>
        @endforeach
    @else 
        <div>木有数据</div>
    @endif
</div>
@endsection

@push('style')
.category-box-title-div{
    margin:5px;
    font-size:16px;
}
.category-box-cate-name{
    font-size:26px;
    font-weight:bold;
    color:lightgrey;
    text-align: left;
    border-bottom:1px solid lightgray;
}

.category-box-main-div{
    border:none;
    padding: 20px;
}
    
@endpush

@section('right')
    @include('component/contactBox')
    @include('component/cateListRight')
    @include('component/recentArticleBox')
@endsection