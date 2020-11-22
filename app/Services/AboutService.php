<?php
/**
 * 用户管理 Service
 *
 * User: Stephen <474949931@qq.com>
 * Date: 2020/6/8
 * Time: 10:03
 */

namespace App\Services;

use App\Http\Model\Common\Attachment;
use App\Http\Model\Common\MenuaboutRelation;
use App\Repositories\Admin\Contracts\AboutInterface;
use App\Repositories\Admin\Contracts\MenuInterface;
use App\Traits\Admin\AdminTree;
use App\Traits\Admin\SearchHandle;
use App\Validate\Admin\AdminMenuValidate;
use Illuminate\Http\Request;

class AboutService extends AdminBaseService
{
    use AdminTree, SearchHandle;

    /**
     * @var Request 框架request对象
     */
    protected $request;

    /**
     * @var AdminMenuValidate 后台菜单验证器
     */
    protected $validate;

    /**
     * @var AboutInterface 菜单仓库
     */
    protected $about;

    protected $menu;

    /**
     * AdminMenuService 构造函数.
     *
     * @param Request $request
     * @param AdminMenuValidate $validate
     * @param AboutInterface $about
     */
    public function __construct(
        Request $request ,
        AdminMenuValidate $validate ,
        AboutInterface $about,
        MenuInterface $menu
    )
    {
        $this->request   = $request;
        $this->validate  = $validate;
        $this->about = $about;
        $this->menu = $menu;
    }

    /**
     * 设置中心 首页数据查询
     *
     * @return array
     * Author: Stephen
     * Date: 2020/7/28 11:18:47
     */
    public function getPageData()
    {
        $param = $this->request->input();
        $data  = $this->about->getPageData($param,$this->perPage());

        return array_merge(['data'  => $data],$this->request->query());
    }

    /**
     * 设置中心 首页数据查询
     *
     * @return array
     * Author: Stephen
     * Date: 2020/7/28 11:18:47
     */
    public function getListsData()
    {
        $param = $this->request->input();
        $query = $this->about->query();
        $query = $this->search($query, $param, $this->getSearchHandles());
        $sort_by = 'create_time';
        $sort = 'desc';
        $page_size = 10;
        $curr_page = 1;
        $is_show = 1;
        if (isset($param['sort_by'])) {
            $sort_by = $param['sort_by'];
        }
        if (isset($param['page_size'])) {
            $page_size = $param['page_size'];
        }
        if (isset($param['curr_page'])) {
            $curr_page = $param['curr_page'];
        }
        if (isset($param['sort'])) {
            $sort = $param['sort'];
        }
        if (isset($param['is_show'])) {
            $is_show = $param['is_show'];
        }

        $curr_start = ($curr_page == 1) ? 0 : $page_size * ($curr_page - 1);
        $abouts['total'] = $query->count();

        $abouts['lists'] = [];
        if (isset($param['multiple_fields'])) {
            $query = $this->getMultipleFieldsQuery($query, $param['multiple_fields'], []);
        }
        $lists = [];
        try{
            $lists = $query->orderBy($sort_by, $sort)
                ->skip($curr_start)
                ->take($page_size)
                ->get();
        } catch (\Exception $e) {

        }
        $abouts['lists'] = $lists;

        return $abouts;
    }

    /**
     * 根据id查找设置
     *
     * @param $id
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/28 11:20:44
     */
    public function findById($id)
    {
        return $this->about->findById($id);
    }

    /**
     * 添加菜单
     *
     * @return array
     * Author: Stephen
     * Date: 2020/7/27 17:05:03
     */
    public function add()
    {
        $parent_id = $this->request->input('parent_id') ?? 0;
        $parents   = $this->menu($parent_id);

        return [
            'parents'    => $parents,
        ];
    }

    /**
     * 生成菜单
     *
     * Author: Stephen
     * Date: 2020/7/27 17:05:43
     */
    public function create()
    {
        $param           = $this->request->input();
        $file = '';
//        if ($this->request->file('img')) {
//            $attachment = new Attachment();
//            $file       = $attachment->upload('img');
//        }
//        if ($file) {
//            $param['img'] = $file->url;
//        }

        $result = $this->about->create($param);

        if (isset($param['is_show']) && $param['is_show'] === 1) {
            $this->about->where('id', '!=', $result->id)->update([
                'is_show' => 0
            ]);
        }

        return $result ? success('添加成功') : error();
    }

    /**
     * 编辑菜单
     *
     * @param $id
     * @return array
     * Author: Stephen
     * Date: 2020/7/27 17:06:00
     */
    public function edit($id)
    {
        $data      = $this->about->findById($id);
        return [
            'data'       => $data,
        ];
    }

    /**
     * 编辑菜单
     *
     * @param $id
     * @return array
     * Author: Stephen
     * Date: 2020/7/27 17:06:00
     */
    public function info()
    {
        $id = $this->request->input('id');
        return $this->about->findById($id);
    }

    /**
     * 更新菜单
     *
     * Author: Stephen
     * Date: 2020/7/27 17:06:28
     */
    public function update()
    {

        $param           = $this->request->input();
        $id = $param['id'];

        $abouts = $this->about->findById($id);

        $result = $abouts->update($param);

        if (isset($param['is_show']) && $param['is_show'] === 1) {
            $abouts->where('id', '!=', $param['id'])->update([
                'is_show' => 0
            ]);
        }

        return $result ? success() : error();
    }

    /**
     * 删除菜单
     *
     * Author: Stephen
     * Date: 2020/7/27 17:06:46
     */
    public function del()
    {
        $id = $this->request->input('id');
        is_string($id) && $id = [$id];

        //删除改about对应的栏目关联
        $count = $this->about->destroy($id);

        return $count > 0 ? success('操作成功', URL_RELOAD) : error();
    }

    /**
     * 菜单选择 select树形选择
     *
     * @param int $selected
     * @param int $current_id
     * @return string
     * Author: Stephen
     * Date: 2020/5/18 16:10
     */
    protected function menu($selected = 1, $current_id = 0)
    {
        $result = $this->menu->menu($current_id);
        $result = array_column($result,NULL,'id');

        foreach ($result as $r) {
            $r['selected'] = (int)$r['id'] === (int)$selected ? 'selected' : '';
        }

        $str = "<option value='\$id' \$selected >\$spacer \$name</option>";
        $this->initTree($result);

        return $this->getTree(0, $str, $selected);
    }

}
