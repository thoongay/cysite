<?php

namespace App\Http\Controllers\Admin;

use App\Events\ArticleUpdated;
use App\Http\Controllers\Controller;
use App\Lib\User as LibUser;
use App\Lib\Utils;
use App\Model\DB\Articles;
use App\Model\DB\Categories;
use App\Model\DB\Images;
use App\Model\DB\Users;
use Illuminate\Http\Request;
use Validator;

class ArticleCtrl extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Articles $articles, Users $users)
    {
        $data = $articles->GetAllArticles();
        $names = $users->GetAllUsersName();
        return view('admin.article.list', compact('data', 'names'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Categories $categories, LibUser $libUser)
    {
        $mark = $libUser->GenToken(32);
        session(['mark' => $mark]);
        $cates = $categories->GetCatesArray();
        return view('admin/article/create', compact('cates', 'mark'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Articles $articles, Images $images, Users $users, Categories $categories)
    {
        $post = $request->post();
        $ip = $request->ip();
        $mark = $post['mark'];

        $validator = $this->VerifyPost($post);

        if (!$validator->passes()) {
            $cache = Utils::CopyArray($post, [
                'title',
                'category',
                'keyword',
                'content',
                'mark']);

            $cache['errors'] = $validator->errors();
            $cache['cates'] = $categories->GetCatesArray();

            return view('admin/article/create', $cache);
        }

        // insert into db articles;
        $article = Utils::CopyArray($post, ['title', 'text', 'category', 'keyword', 'content']);
        $article['author'] = $users->GetIdByFieldUser(session('user'));
        $id = $articles->create($article)->id;

        // connect uploaded images to articles
        $images->Connect($mark, $id);

        // update article
        event(new ArticleUpdated());

        return redirect('admin/article');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\DB\Articles  $articles
     * @return \Illuminate\Http\Response
     */
    public function show(Articles $articles)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\DB\Articles  $articles
     * @return \Illuminate\Http\Response
     */
    public function edit(Articles $articles, Categories $categories, LibUser $libUser, $id)
    {
        $mark = $libUser->GenToken(32);
        session(['mark' => $mark]);

        $article = $articles->where(['id' => $id])->first();
        $cache = Utils::CopyArray($article, ['title', 'category', 'keyword', 'content']);
        $cache['id'] = $id;
        $cache['mark'] = $mark;
        $cache['cates'] = $categories->GetCatesArray();

        return view('admin/article/edit', $cache);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\DB\Articles  $articles
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Articles $articles, Images $images, Users $users, Categories $categories, $id)
    {
        $post = $request->post();
        $ip = $request->ip();
        $mark = $post['mark'];

        $validator = $this->VerifyPost($post);

        $cache = Utils::CopyArray($post, ['title', 'category', 'keyword', 'content', 'mark']);
        $cache['id'] = $id;
        $cache['cates'] = $categories->GetCatesArray();

        if (!$validator->passes()) {
            $cache['errors'] = $validator->errors();
            return view('admin/article/edit', $cache);
        }

        $article = $articles->where(['id' => $id])->first();
        if ($article == null) {
            Utils::Log('修改文章信息 - 文章不存在', $ip);
            $cache['errors'] = "没有这篇文章，更新失败。";
            return view('admin/article/edit', $cache);
        }

        // insert into db articles;

        $article['author'] = $users->GetIdByFieldUser(session('user'));
        $article['text'] = $post['text'];
        foreach (['title', 'content', 'category', 'keyword'] as $key) {
            $article[$key] = $cache[$key];
        }

        $article->update();

        // connect uploaded images to articles
        $images->Connect($mark, $id);

        // update article
        event(new ArticleUpdated());

        return redirect('admin/article');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\DB\Articles  $articles
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Articles $articles, Images $images, $id)
    {
        $ip = $request->ip();
        $record = $articles->where('id', $id);
        $article = $record->first();
        $title = $article->title;
        $record->delete();

        if ($record) {
            $msg = ['status' => true, 'msg' => '删除成功'];
            Utils::Log("删除文章$id.$title 成功", $ip);
        } else {
            $msg = ['status' => false, 'msg' => '删除失败'];
            Utils::Log("删除文章$id.$title 失败", $ip);
        }

        $images->Disconnect($id);

        // update article
        event(new ArticleUpdated());

        return $msg;
    }

    #region private method
    private function VerifyPost($post)
    {
        $titleLen = config('app.admin.articleTitleLength');
        $contentLen = config('app.admin.articleContentLength');
        $keywordLen = config('app.admin.articleKeywordLength');

        $rules = [
            'mark' => "required|size:32",
            'title' => "required|between:1,{$titleLen}",
            'content' => "required|between:1,{$contentLen}",
            'text' => "required|between:1,{$contentLen}",
            'keyword' => "required|between:1,{$keywordLen}",
        ];

        $errors = [
            'mark.required' => 'emm,标记不能为空',
            'mark.size' => 'emm,标记长度不符',
            'title.required' => '标题不能为空',
            'content.required' => '内容不能为空',
            'text.required' => '文本不能为空',
            'keyword.required' => '关键词不能为空',

            'title.between' => "标题应在{$titleLen}字符以内",
            'content.between' => "内容应在{$contentLen}字符以内",
            'text.between' => "emm,纯文本应在{$contentLen}字符以内",
            'keyword.between' => "关键词应在{$keywordLen}字符以内",
        ];

        return Validator::make($post, $rules, $errors);
    }
    #endregion
}
