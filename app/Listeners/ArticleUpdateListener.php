<?php

namespace App\Listeners;

use App\Events\ArticleUpdated;
use App\Lib\Utils;
use App\Model\DB\Articles;
use App\Model\DB\Categories;

class ArticleUpdateListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ArticleUpdated  $event
     * @return void
     */
    public function handle(ArticleUpdated $event)
    {
        $setKey = 'ShowCates';
        $setting = Utils::GetSettingContent();
        if (!array_key_exists($setKey, $setting)) {
            Utils::Log('Error: 没有ShowCates设置，无法更新文章缓存。');
            return;
        }
        $keys = explode(',', $setting[$setKey]);

        $articles = new Articles();
        $categories = new Categories();

        $cateArray = $categories->GetCatesArray();

        Utils::ExportArrayToFile(
            Utils::GetArticleCachePath(),
            $articles->GetRecentArticles($keys, $cateArray));

        // Utils::Log("Event article cache updated.");
    }
}
