<?php

use App\Lib\Utils;

$articleCache = Utils::GetArticleCacheContent();
$setting=Utils::GetSettingContent();

$GetSetting = function($key, $default) use ($setting)
{
    return Utils::GetValue($key,$setting,$default);
};

$artNum=intval($GetSetting('RecentArticleNum',$setting,'10'));
$artLimit=min($artNum,count($articleCache));
$articles=[];
for($i=0;$i<$artLimit;$i++){
    $articles[]=$articleCache[$i];
}

?>

<div class="recent-article-box-div-main">
    <div class="recent-article-box-title">最新文章</div>
    <div>
        @foreach($articles as $art)
        <div class="recent-article-box-link-div">
            <a href="{{url("article/".$art['id'])}}"  title="{{$art['title']}}">{{$art['title']}}</a>
            <span>{{date('Y/M/d',$art['create'])}}</span>
        </div>
        @endforeach
    </div>
</div>

@push('style')
.recent-article-box-link-div{
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
    margin:3px;
}

.recent-article-box-div-main{
    margin: 8px;
    padding: 8px;
    border-left: 1px solid lightgray;
}

{{-- .recent-article-box-div-main a{
    display: block;
    margin: 6px;
    background: darkcyan;
    padding: 5px;
    text-align: center;
    border-radius: 5px;
    color: white;
    font-weight: bold;
} --}}

.recent-article-box-title{
    font-size:18px;
    color: grey;
    padding-left: 10px;
    {{-- border-bottom:1px solid lightgray; --}}
}
    
@endpush