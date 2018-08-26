<?php
use App\Lib\Utils;

$setting=Utils::GetSettingContent();

$GetSetting = function($key, $default) use ($setting)
{
    return Utils::GetValue($key,$setting,$default);
};

// function GetSetting($key,$default) use ($setting){
//     return Utils::GetValue($key,$setting,$default);
// }

$cateString=$GetSetting('HomeCates',$setting,false);
$cates=$cateString?explode(',',$cateString):[];
$pageTitle=$GetSetting('PageTitle','木有标题');
?>

@extends('layout.index',['tagTitle'=>$GetSetting('TagTitle','欢迎访问 - 主页')])

@section('body')
    @include('component.header',['pageTitle'=>$pageTitle])
    @include('component.nav',['cates'=>$cates,'pageTitle'=>$pageTitle])
@endsection

@push('style')
@endpush