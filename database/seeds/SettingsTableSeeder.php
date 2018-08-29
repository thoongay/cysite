<?php

use App\Model\DB\Settings;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // name type description
        $data = [];
        $data[] = $this->GenData('PageTitle', 'text', '网站标题');
        $data[] = $this->GenData('ShowCates', 'text', '主页显示分类');
        $data[] = $this->GenData('FootNode', 'text', '页脚');
        $data[] = $this->GenData('TagTitle', 'text', '标签标题');
        $data[] = $this->GenData('ContactMethods', 'textarea', '联系方式');
        $data[] = $this->GenData('RecentArticleNum', 'text', '显示最新文章数');
        $data[] = $this->GenData('NavCates', 'text', '导航栏显示分类');
        $data[] = $this->GenData('IndexComponents', 'text', '主页内容键名');
        $data[] = $this->GenData('IndexAbout', 'textarea', '第一行 关于');
        $data[] = $this->GenData('IndexServices', 'textarea', '第二行 服务列表');
        $data[] = $this->GenData('IndexQnA', 'textarea', '常见问题');

        (new Settings())->insert($data);
    }

    private function GenData($name, $type, $description)
    {
        return [
            'name' => $name,
            'type' => $type,
            'description' => $description,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
    }
}
