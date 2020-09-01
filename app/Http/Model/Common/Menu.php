<?php
/**
 * 用户模型
 *
 * @author yuxingfei<474949931@qq.com>
 */

namespace App\Http\Model\Common;

class Menu extends BaseModel
{

    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';

    /**
     * 与模型关联的表名
     *
     * @var string
     */
    protected $table = 'menu';

    /**
     * 重定义主键
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * 指示是否自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'U';

    /**
     * 不可批量赋值的属性。
     *
     * @var array
     */
    protected $guarded = [];

    //可搜索字段
    protected $searchField = ['title', 'url', 'desc', 'sort',];

    /**
     * 模型事件
     *
     * Author: Stephen
     * Date: 2020/5/18 16:59
     */
    protected static function booted()
    {
    }
}
