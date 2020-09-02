<?php


namespace App\Traits\Admin;


trait MenuTree
{
    /**
     * 获取到树状列表
     *
     * @param $data //原始ORM查询出的Model数据
     * @param int $parentId //返回的层级
     * @param string $children  //子节点键名
     * @return array    //返回数据
     */
    public function getMenuTree($data, $parentId = 0, $children = 'children') {
        $list = [];
        foreach ($data as $val) {
            $child = $obj{$val->id}[$children] ?? [];
            $obj{$val->id} = $val->jsonSerialize();
            $obj{$val->id}[$children] = $child;
            if ($val->parent_id == $parentId) {
                $list[] = &$obj{$val->id};
            } else {
                $obj{$val->parent_id}[$children][] = &$obj{$val->id};
            }
        }
        return array_merge([], $list);
    }
}
