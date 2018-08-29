<?php

use App\Lib\Utils;

$setting=Utils::GetSettingContent();

$GetSetting = function($key, $default) use ($setting)
{
    return Utils::GetValue($key,$setting,$default);
};

$contactString=$GetSetting('ContactMethods',$setting,false);
$contactMethods=$contactString?explode(",",$contactString):[];
?>

<div class="contact-box-div-main">
    <div class="contact-box-title">联系方式</div>
    <ul>
        @foreach($contactMethods as $c)
            <li>{{$c}}</li>
        @endforeach
    </ul>
</div>

@push('style')
.contact-box-div-main{
    margin: 8px;
    padding: 8px;
    border-left: 1px solid lightgray;
}

.contact-box-div-main ul{
    list-style-type: none;
    padding: 10px;       
}

.contact-box-div-main  ul li{
    display: block;
}

.contact-box-title{
    font-size:18px;
    color: grey;
    padding-left: 10px;
    {{-- border-bottom:1px solid lightgray; --}}
}
    
@endpush