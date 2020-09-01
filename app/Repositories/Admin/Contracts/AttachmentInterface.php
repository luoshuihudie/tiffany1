<?php
/**
 * Created by PhpStorm.
 *
 * User: Stephen <474949931@qq.com>
 * Date: 2020/7/23
 * Time: 16:25
 */

namespace App\Repositories\Admin\Contracts;


interface AttachmentInterface
{
    /**
     * 设置界面首页数据查询
     *
     * @param $param
     * @param $perPage
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:16:00
     */
    public function getPageData($param,$perPage);

    /**
     * 根据id查找设置信息
     *
     * @param $id
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:17:20
     */
    public function findById($id);

    /**
     * 创建设置数据
     *
     * @param $param
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:17:45
     */
    public function create($param);

    /**
     * 删除设置数据
     *
     * @param $id
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:17:56
     */
    public function destroy($id);

}
