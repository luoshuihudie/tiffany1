<?php
/**
 * 友情链接管理 控制器
 *
 * User: Stephen <474949931@qq.com>
 * Date: 2020/6/10
 * Time: 10:11
 */

namespace App\Http\Controllers\Admin;

use App\Services\MenuService;

class MenuController extends BaseController
{

    /**
     * @var MenuService 设置服务
     */
    protected $menuService;

    /**
     * SettingController 构造函数.
     *
     * @param MenuService $linksService
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct(MenuService $menuService)
    {
        parent::__construct();

        $this->menuService = $menuService;
    }

    /**
     * 设置列表页
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Author: Stephen
     * Date: 2020/7/24 16:13:14
     */
    public function index()
    {
        $data = $this->menuService->websiteMenuTree();

        return view('admin.menu.index',['data'  => $data]);
    }

    /**
     * 设置列表页
     *
     * @return array
     */
    public function lists()
    {
        $data = $this->menuService->getListsData();

        return $this->ajaxSuccess($data);
    }

    /**
     * 更新配置
     *
     * Author: Stephen
     * Date: 2020/7/24 16:14:16
     */
    public function update()
    {
        return $this->menuService->update();
    }

    /**
     * 添加设置界面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Author: Stephen
     * Date: 2020/7/24 16:15:10
     */
    public function add()
    {
        $data = $this->menuService->add();

        return view('admin.menu.add', ['parents' => $data['parents']]);
    }

    /**
     * 创建设置
     *
     * Author: Stephen
     * Date: 2020/7/24 16:15:20
     */
    public function create()
    {
        return $this->menuService->create();
    }

    /**
     * 编辑设置界面
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Author: Stephen
     * Date: 2020/7/24 16:15:29
     */
    public function edit($id)
    {
        $data = $this->menuService->edit($id);

        return view('admin.menu.edit', $data);
    }

    /**
     * 删除设置
     *
     * Author: Stephen
     * Date: 2020/7/24 16:16:12
     */
    public function del()
    {
        return $this->menuService->del();
    }

    /**
     * 删除设置
     *
     * Author: Stephen
     * Date: 2020/7/24 16:16:12
     */
    public function info()
    {
        return $this->menuService->del();
    }

}
