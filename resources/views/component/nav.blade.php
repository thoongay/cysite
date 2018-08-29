<?php

use App\Lib\Utils;

$GetSetting = Utils::GetSettingHelper();
$navCates=Utils::Str2Arr($GetSetting('NavCates',false));

?>
<nav >
    <ul>
        <li><a href='{{url("/")."#header"}}'>主页</a></li>
        <li><a href='{{url("/")."#services"}}'>服务项目</a></li>
        @foreach($navCates as $cate)
            <li><a href='{{url('category/'.$cate)}}'>{{$cate}}</a></li>
        @endforeach
        <li><a href='{{url("/")."#about"}}'>关于</a></li>
    </ul>
</nav>