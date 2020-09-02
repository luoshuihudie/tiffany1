<?php
/**
 * 友情链接 仓库
 *
 * User: Stephen <474949931@qq.com>
 * Date: 2020/6/5
 * Time: 17:03
 */

namespace App\Repositories\Admin\Eloquent;

use App\Http\Model\Common\Menu;
use App\Repositories\Admin\Contracts\MenuInterface;

class MenuRepository implements MenuInterface
{
    /**
     * 根据id查找设置信息
     *
     * @param $id
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:38:07
     */
    public function findById($id)
    {
        return Menu::find($id);
    }

    /**
     * 查询所有菜单
     *
     * @return array|mixed
     * Author: Stephen
     * Date: 2020/7/27 16:25:56
     */
    public function allWebsiteMenu()
    {
        $result = Menu::orderBy('sort_id','asc')->orderBy('id','asc')->get()->toArray();

        return array_column($result,NULL,'id');
    }

    /**
     * 除去当前id之外的所有菜单id
     *
     * @param int $current_id
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:26:09
     */
    public function menu($current_id = 0)
    {
        return Menu::where('id', '<>', $current_id)
            ->orderBy('sort_id', 'asc')
            ->orderBy('id', 'asc')
            ->get(['id','parent_id','name','sort_id'])
            ->toArray();
    }

    /**
     * 设置界面首页数据查询
     *
     * @param $param
     * @param $perPage
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:37:51
     */
    public function getPageData($param, $perPage)
    {
        $query = Menu::addWhere($param);
        $orderBys['create_time'] = 'desc';
        if (isset($param['sort']) && in_array($param['sort'], ['asc', 'desc'])) {
            $orderBys['sort'] = $param['sort'];
        }

        foreach ($orderBys as $key => $orderBy) {
            $query = $query->orderBy($key, $orderBy);
        }

        return $query->paginate($perPage);
    }

    /**
     * 创建设置数据
     *
     * @param $param
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:37:32
     */
    public function create($param)
    {
        return Menu::create($param);
    }

    /**
     * 创建设置数据
     *
     * @param $param
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:37:32
     */
    public function query()
    {
        return Menu::query();
    }

    /**
     * 删除设置数据
     *
     * @param $id
     * @return int|mixed|void
     * Author: Stephen
     * Date: 2020/7/27 16:37:11
     */
    public function destroy($id)
    {
        //判断是否有子菜单
        $have_son = Menu::whereIn('parent_id', $id)->first();

        if ($have_son) {
            return error('有子菜单不可删除！请先删除子菜单');
        }
        is_string($id) && $id = [$id];

        $noDeletionId = (new Menu())->getNoDeletionId();

        if (count($noDeletionId) > 0) {
            if (is_array($id)) {
                if (array_intersect($noDeletionId, $id)) {
                    return error('ID为' . implode(',', $noDeletionId) . '的数据无法删除');
                }
            } else if (in_array($id, $noDeletionId)) {
                return error('ID为' . $id . '的数据无法删除');
            }
        }

        $count = Menu::destroy($id);

        return $count;
    }

}
