@extends('layout.admin',['title' => '系统信息'])

<?php 
use App\Lib\Utils;
$os=Utils::GetOSInfo();
$browser=Utils::GetBrowserInfo();
$version=PHP_VERSION;
?>

@section('content')
<ul>
    <li>操作系统：{{$os or '无'}}</li>
    <li>浏览器：{{$browser or '无'}}</li>
    <li>服务器版本：{{$_SERVER ['SERVER_SOFTWARE'] or '无'}}</li>
    <li>PHP版本：{{$version or '无'}}</li>
    <li>最大上传限制：{{get_cfg_var ("upload_max_filesize")?get_cfg_var ("upload_max_filesize"):"不允许上传附件"}}</li>
    <li>最大执行时间：{{get_cfg_var("max_execution_time")."秒 "}}</li>
    <li>脚本运行占用最大内存：{{get_cfg_var ("memory_limit")?get_cfg_var("memory_limit"):"无"}}</li>
    <li>ZEND版本：{{zend_version()}}</li>
</ul>
@endsection