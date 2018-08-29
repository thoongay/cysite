@extends('layout.index.leftright')

@section('top')
    @include('component/cateListTop')
@endsection

@section('left')
    {{-- @include('component/articlebox',compact('title','author','create','content')) --}}
    <div class="article-box-main-div">
        <div class="article-box-title">{{$title}}</div>
        <div class="article-box-info">
            <div class="article-box-author">{{$author}}</div>
            <div class="article-box-create">{{date('Y/M/d', $create)}}</div>
        </div>
        <div class="article-box-contnet">{!!$content!!}</div>
    </div>
@endsection

@section('right')
    @include('component/contactBox')
    @include('component/cateListRight')
    @include('component/recentArticleBox')
@endsection

@push('style')
.article-box-title{
    font-size:30px;
    font-weight:bold;
    text-align: center;
}

.article-box-info{
    border-top:1px solid lightgray;
    border-bottom:1px solid lightgray;
    color:lightgrey;
    margin: 10px 0px 10px 0px;
    padding: 6px;
    font-size:15px;
    text-align: center;
}

.article-box-author{
    display: inline-block;
}

.article-box-create{
    display: inline-block;
}

.article-box-content{
    
}

.article-box-main-div{
    border:none;
    padding: 20px;
}
    
@endpush