<?php

use App\Lib\Utils;

$GetSetting=Utils::GetSettingHelper();
$cates=Utils::Str2Arr($GetSetting('ShowCates', false));

?>

<div class="cate-box-right-div-main">
    <div class="cate-box-right-title">分类列表</div>
    <div>
        @include('component.cateButtons',compact('cates'))
    </div>
</div>

@push('style')
.cate-box-right-div-main{
    margin: 8px;
    padding: 8px;
    border-left: 1px solid lightgray;
}

.cate-box-right-div-main a{
    display: block;
    margin: 6px;
    background: darkcyan;
    padding: 5px;
    text-align: center;
    border-radius: 5px;
    color: white;
    font-weight: bold;
}

.cate-box-right-title{
    font-size:18px;
    color: grey;
    padding-left: 10px;
}
    
@endpush