<?php
/**
 * 友情链接管理 控制器
 *
 * User: Stephen <474949931@qq.com>
 * Date: 2020/6/10
 * Time: 10:11
 */

namespace App\Http\Controllers\Admin;

use App\Services\AttachmentService;
use App\Services\BannerService;

class AttachmentController extends BaseController
{

    /**
     * @var AttachmentService 设置服务
     */
    protected $attachmentService;

    /**
     * SettingController 构造函数.
     *
     * @param AttachmentService $linksService
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct(AttachmentService $attachmentService)
    {
        parent::__construct();

        $this->attachmentService = $attachmentService;
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
        $data = $this->attachmentService->getPageData();

        return view('admin.attachment.index',$data);
    }

    /**
     * 设置列表页
     *
     * @return array
     */
    public function lists()
    {
        $data = $this->attachmentService->getListsData();

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
        return $this->attachmentService->update();
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
        return view('admin.attachment.add');
    }

    /**
     * 创建设置
     *
     * Author: Stephen
     * Date: 2020/7/24 16:15:20
     */
    public function create()
    {
        return $this->attachmentService->create();
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
        $data = $this->attachmentService->findById($id);

        return view('admin.attachment.edit',[
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
        return $this->attachmentService->del();
    }

}
