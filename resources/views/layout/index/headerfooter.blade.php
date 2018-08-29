<?php
use App\Lib\Utils;

$GetSetting = Utils::GetSettingHelper();
$cates=Utils::Str2Arr($GetSetting('ShowCates',false));
$pageTitle=$GetSetting('PageTitle','木有标题');
?>

@extends('layout.index.resource',['tagTitle'=>$GetSetting('TagTitle','欢迎访问 - 主页')])

@section('body')
<div class="body-wrapper">
    @include('component.header',['pageTitle'=>$pageTitle,'cates'=>$cates])
    <div class="headerfooter-content-div">
        @yield('content','木有content')
    </div>
    @include('component.footer')
</div>
@endsection

@push('style')
.body-wrapper{
    width:100%;
    min-width:320px;
}

.headerfooter-content-div{
    margin-top: 44px;
}
@endpush