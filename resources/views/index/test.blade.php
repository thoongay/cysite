<?php

use App\Lib\Utils;

$GetSetting=Utils::GetSettingHelper();

$partsName=Utils::Str2Arr($GetSetting('IndexComponents',false));

$partsArr=[];
foreach($partsName as $key){
    // replace this with publish.php in real index page
    $v=$GetSetting($key,false);
    if($v){
        $partsArr[$key]=$v;
    }
}

?>

@extends('layout.index.headerfooter')

@section('content')
    <div class="anchor"><a id="header"></a></div>
    <div class="index-div-main">
    @foreach ($partsArr as $part)
        <div style="display:block;">
            {!!$part!!}
        </div>
    @endforeach
    </div>
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