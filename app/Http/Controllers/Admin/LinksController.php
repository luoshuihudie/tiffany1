<?php
/**
 * 友情链接管理 控制器
 *
 * User: Stephen <474949931@qq.com>
 * Date: 2020/6/10
 * Time: 10:11
 */

namespace App\Http\Controllers\Admin;

use App\Services\LinksService;

class LinksController extends BaseController
{

    /**
     * @var LinksService 设置服务
     */
    protected $linksService;

    /**
     * SettingController 构造函数.
     *
     * @param LinksService $linksService
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct(LinksService $linksService)
    {
        parent::__construct();

        $this->linksService = $linksService;
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
        $data = $this->linksService->getPageData();

        return view('admin.links.index',$data);
    }

    /**
     * 设置列表页
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Author: Stephen
     * Date: 2020/7/24 16:13:14
     */
    public function lists()
    {
        $data = $this->linksService->getListsData();

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
        return $this->linksService->update();
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
        return view('admin.links.add');
    }

    /**
     * 创建设置
     *
     * Author: Stephen
     * Date: 2020/7/24 16:15:20
     */
    public function create()
    {
        return $this->linksService->create();
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
        $data = $this->linksService->findById($id);

        return view('admin.links.edit',[
            'data'               => $data,
        ]);
    }

    /**
     * 删除设置
     *
     * Author: Stephen
     * Date: 2020/7/24 16:16:12
     */
    public function del()
    {
        return $this->linksService->del();
    }

}
