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
<div class="body-wrapper">
    @include('component.header',[
        'pageTitle'=>$pageTitle,
        'phoneNumber'=>$GetSetting('PhoneNumber','123-1234-1234'),
        'wechatNumber'=>$GetSetting('WechatNumber','123-1234-1234'),
        'cates'=>$cates])
    @include('component.footer')
</div>
@endsection

@push('style')
.body-wrapper{
    width:100%;
}
@endpush