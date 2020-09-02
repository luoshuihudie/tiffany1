<?php
/**
 * 友情链接管理 控制器
 *
 * User: Stephen <474949931@qq.com>
 * Date: 2020/6/10
 * Time: 10:11
 */

namespace App\Http\Controllers\Admin;

use App\Services\BannerService;

class BannerController extends BaseController
{

    /**
     * @var BannerService 设置服务
     */
    protected $bannerService;

    /**
     * SettingController 构造函数.
     *
     * @param BannerService $linksService
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct(BannerService $bannerService)
    {
        parent::__construct();

        $this->bannerService = $bannerService;
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
        $data = $this->bannerService->getPageData();

        return view('admin.banner.index',$data);
    }

    /**
     * 设置列表页
     *
     * @return array
     */
    public function lists()
    {
        $data = $this->bannerService->getListsData();

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
        return $this->bannerService->update();
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
        $data = $this->bannerService->add();
        return view('admin.banner.add', $data);
    }

    /**
     * 创建设置
     *
     * Author: Stephen
     * Date: 2020/7/24 16:15:20
     */
    public function create()
    {
        return $this->bannerService->create();
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
        $data = $this->bannerService->edit($id);

        return view('admin.banner.edit', $data);
    }

    /**
     * 删除设置
     *
     * Author: Stephen
     * Date: 2020/7/24 16:16:12
     */
    public function del()
    {
        return $this->bannerService->del();
    }

}
