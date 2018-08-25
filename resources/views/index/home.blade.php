<?php
$filename = app_path() . config('app.admin.settingFilePath');
$setFile=[];
if (file_exists($filename)) {
    $setFile = include $filename;
}
?>

@extends('layout.index',['pageTitle'=>array_key_exists('title',$setFile)?$setFile['title']:'主页'])

@section('body')
<div class="wrapper">
    @include('component.nav',['cates'=>['news','info','pricing']])
</div>
@endsection