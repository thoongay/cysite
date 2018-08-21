<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Lib\Utils;
use App\Model\DB\Categories;
use Illuminate\Http\Request;
use Validator;

class CategoryCtrl extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Categories $categories)
    {
        $data = $categories->GetAllCategories();
        return view('admin.category.list', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/category/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Categories $categories)
    {
        $post = $request->post();
        $ip = $request->ip();

        $validator = $this->VerifyPost($post);

        if (!$validator->passes()) {
            return back()->withErrors($validator);
        }

        if (!$validator->passes()) {
            return back()->withErrors($validator);
        }

        $cate = $categories->firstOrNew(array('name' => $post['name']));
        $cate->description = $post['description'];
        $cate->save();
        return redirect('admin/category');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\DB\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function show(Categories $categories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\DB\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function edit(Categories $categories, $id)
    {
        $cate = $categories->where(['id' => $id])->first();
        $data = Utils::CopyArray($cate, ['id', 'name', 'description']);

        return view('admin.category.edit', compact('data'));
    }

    private function VerifyPost($post)
    {
        $cateNameLen = config('app.admin.cateNameLength');
        $cateDscrLen = config('app.admin.cateDscrLength');

        $rules = [
            'name' => "required|between:1,{$cateNameLen}",
            'description' => "required|between:1,{$cateNameLen}",
        ];

        $errors = [
            'name.required' => '名字不能为空',
            'name.between' => "名字应为1-{$cateNameLen}位之间",
            'description.required' => '描述不能为空',
            'description.between' => "描述应为1-{$cateDscrLen}位之间",
        ];

        return Validator::make($post, $rules, $errors);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\DB\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Categories $categories, $id)
    {
        $post = $request->post();
        $ip = $request->ip();

        $validator = $this->VerifyPost($post);

        if (!$validator->passes()) {
            return back()->withErrors($validator);
        }

        $cate = $categories->where(['id' => $id])->first();

        if ($cate == null) {
            Utils::Log('修改分类信息 - 分类不存在', $ip);
            return back()->withErrors('没有这个分类');
        }

        $cate->name = $post['name'];
        $cate->description = $post['description'];
        $cate->update();
        return redirect('admin/category');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\DB\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Categories $categories, $id)
    {
        $ip = $request->ip();
        $cate = $categories->where('id', $id);
        $info = $cate->first();
        $name = $info->name;
        $cate->delete();

        if ($cate) {
            $msg = ['status' => true, 'msg' => '删除成功'];
            Utils::Log("删除分类$id.$name 成功", $ip);
        } else {
            $msg = ['status' => false, 'msg' => '删除失败'];
            Utils::Log("删除分类$id.$name 失败", $ip);
        }

        return $msg;
    }
}
