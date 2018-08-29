<?php

use App\Lib\Utils;

$GetSetting=Utils::GetSettingHelper();
$partsName=Utils::Str2Arr($GetSetting('IndexComponents',false));
$partsArr=Utils::GetPHPFileContent(Utils::GetPublishPath());

?>

@extends('layout.index.headerfooter')

@section('content')
    <div class="anchor"><a id="header"></a></div>
    @foreach ($partsArr as $part)
        <div style="display:block;">
            {!!$part!!}
        </div>
    @endforeach
@endsection

@push('style')
.anchor a {
    position: absolute;
    left: 0px;
    top: -44px;
}

.anchor {
    position: relative;
}

.index-div-main{
    margin-top:44px;
}

.index-component-div{
    display:block;
    padding: 16px;
}

.index-component-title{
    font-size:24px;
    color:gray;
    padding-left: 20px;
    padding-right: 20px;
    border-bottom: 1px solid lightgray;
}

.index-component-content-div{
    padding:20px;
}

@endpush