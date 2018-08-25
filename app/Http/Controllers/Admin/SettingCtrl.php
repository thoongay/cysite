<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Lib\Utils;
use App\Model\DB\Settings;
use Illuminate\Http\Request;
use Validator;

class SettingCtrl extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $settingsType = ['text', 'textarea', 'checkbox'];

    #region public method

    // page for setting content
    public function ModifySetting(Request $request)
    {
        $post = $request->except('_token');

        $setting = [];
        foreach ($post as $name => $conents) {
            $setting[$name] = implode(",", $conents);
        }

        $filename = app_path() . config('app.admin.settingFilePath');
        file_put_contents($filename, '<?php return ' . var_export($setting, true) . ';');
        return redirect('admin/setting/modify');
    }

    public function ShowModifySettingPage(Settings $settings)
    {
        $fileContent = [];
        $filename = app_path() . config('app.admin.settingFilePath');
        if (file_exists($filename)) {
            $fileContent = include $filename;
        }

        // 应该使用简单结构 [id,name,type,option,content]
        $data = [];
        foreach ($settings->GetAllSetting() as $setting) {
            $d = Utils::CopyArray($setting, ['id', 'name', 'type', 'option']);
            $name = $d['name'];
            if (array_key_exists($name, $fileContent)) {
                $d['content'] = $fileContent[$name];
            } else {
                $d['content'] = '';
            }
            $data[] = $d;
        }

        $settingsType = $this->GetSettingsType();
        return view('admin/setting/modify', compact('settingsType', 'data'));
    }

    public function GetSettingsType()
    {
        return $this->settingsType;
    }

    public function index(Settings $settings)
    {
        $data = $settings->GetAllSetting();
        $optionTypes = $this->GetSettingsType();
        return view('admin.setting.list', compact('data', $optionTypes));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $optionTypes = $this->GetSettingsType();
        return view('admin/setting/create', compact('optionTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Settings $settings)
    {
        $post = $request->post();
        $ip = $request->ip();

        $validator = $this->VerifyPost($post);
        if (!$validator->passes()) {
            return back()->withErrors($validator);
        }

        $setting = $settings->firstOrNew(['name' => $post['name']]);
        $setting->type = $post['type'];
        $key = 'option';
        if (array_key_exists($key, $post)) {
            $setting[$key] = $post[$key];
        }
        $setting->save();
        return redirect('admin/setting');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\DB\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function show(Settings $settings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\DB\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function edit(Settings $settings, $id)
    {
        $setting = $settings->GetSettingByFieldID($id);
        if ($setting == null) {
            return redirect('admin/setting/');
        }

        $data = Utils::CopyArray($setting, ['id', 'name', 'type', 'option']);
        $optionTypes = $this->GetSettingsType();
        return view('admin/setting/edit', compact('optionTypes', 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\DB\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Settings $settings, $id)
    {
        $post = $request->post();
        $ip = $request->ip();

        $validator = $this->VerifyPost($post);

        if (!$validator->passes()) {
            return back()->withErrors($validator);
        }

        $setting = $settings->where(['id' => $id])->first();

        if ($setting == null) {
            Utils::Log('修改配置信息 - 配置项不存在', $ip);
            return back()->withErrors('没有这个配置');
        }

        $setting->name = $post['name'];
        $setting->type = $post['type'];
        $key = 'option';
        if (array_key_exists($key, $post)) {
            $setting[$key] = $post[$key];
        }
        $setting->update();
        return redirect('admin/setting');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\DB\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Settings $settings, $id)
    {
        $ip = $request->ip();
        $setting = $settings->where('id', $id);
        $info = $setting->first();
        $name = $info->name;
        $setting->delete();

        if ($setting) {
            $msg = ['status' => true, 'msg' => '删除成功'];
            Utils::Log("删除配置$id.$name 成功", $ip);
        } else {
            $msg = ['status' => false, 'msg' => '删除失败'];
            Utils::Log("删除配置$id.$name 失败", $ip);
        }

        return $msg;
    }

    #endregion

    #region private medhod
    private function VerifyPost($post)
    {
        $settingNameLen = config('app.admin.settingNameLength');
        $settingOptLen = config('app.admin.settingOptionLength');

        $rules = [
            'name' => "required|between:1,{$settingNameLen}",
            'type' => "required|between:1,{$settingNameLen}",
            'option' => "nullable|between:2,{$settingOptLen}",
        ];

        $errors = [
            'name.required' => '名字不能为空',
            'name.between' => "名字应为1-{$settingNameLen}位之间",
            'type.required' => '类型不能为空',
            'type.between' => "类型应为1-{$settingNameLen}位之间",
            'option.between' => "选项应为2-{$settingOptLen}位之间",
        ];

        return Validator::make($post, $rules, $errors);
    }

    #endregion
}
