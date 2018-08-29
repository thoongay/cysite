<?php

use App\Lib\Utils;

$GetSetting=Utils::GetSettingHelper();
$cates=Utils::Str2Arr($GetSetting('ShowCates', false));

?>

<div class="cate-box-top-div-main show-on-tablet">
    @include('component.cateButtons',compact('cates'))
</div>

@push('style')
.cate-box-top-div-main{
}

.cate-box-top-div-main a{
    width:50px;
    margin-top: 6px;
    margin-left: 6px;
    padding: 6px 12px;
    display: inline-block;
    background: darkcyan;
    text-align: center;
    border-radius: 5px;
    color: white;
    font-weight: bold;
}
@endpush