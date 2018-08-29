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

<div class="footer-div-main flex-container">
    <div class="footer-qrcode-container">
        <div class="footer-qrcode" ></div>
        <div class="footer-qrcode" ></div>
    </div>

    <div class="footer-service">
        <dl>
            <dt>产品服务</dt>
            <dd>服务1</dd>
            <dd>服务1</dd>
            <dd>服务1</dd>
        </dl>
    </div>

    <div class="footer-contact">
        <dl>
            <dt>与我联系</dt>
            @foreach($contactMethods as $c)
                <dd>{{$c}}</dd>
            @endforeach
        </dl>
    </div>
    
</div>

@push('style')
.footer-qrcode{
    margin-right: 16px;
    margin-left: 16px;
    width:110px;
    height:110px;
    background-color:white;
}

.footer-qrcode-container{
    flex-grow:1;
    min-width:160px;
    min-height:160px;
    display: flex;
    justify-content: center;
    align-items: center; 
}

.footer-service{
    flex-grow:2;
    min-width:180px;
    margin:18px;
}

.footer-contact{
    flex-grow:3;
    min-width:220px;
    margin:18px;
}



.footer-div-main{
    width:100%;
    flex-wrap:wrap;
    background-color: darkslategrey;
    color: lightgray;
}

.footer-div-main dt{
    font-weight:bold;
}

.footer-div-main dd{
    font-weight:normal;
}
@endpush

@push('script')
   
@endpush