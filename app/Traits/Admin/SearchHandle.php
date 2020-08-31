<?php


namespace App\Traits\Admin;


trait SearchHandle
{
    /**
     *设置搜索处理条件
     *
     * @return array
     */
    public function getSearchHandles()
    {
        return [
//            'search' => function ($query, $value) {
//                $query->where(function ($q) use ($value) {
//                    $q->where(
//                        'name',
//                        'like',
//                        '%' . $value . '%'
//                    )
//                        ->orWhere('id', $value);
//                });
//            }
        ];
    }

    /**
     * 根据前端传递的参数组装SQL WHERE条件
     *
     * @param $query //QueryBuilder
     * @param $params //前端传递过来的参数
     * @param $handles //根据getSearchHandles方法获取到设置后的处理条件
     * @return mixed //返回组装后的query语句
     */
    public function search($query, $params, $handles)
    {
        foreach ($handles as $key => $value) {
            if (isset($params[$key]) && is_callable($value)) {
                $handles[$key]($query, $params[$key], $params);
            }
        }
        return $query;
    }

    /**
     * 多字段排序
     *
     * @param $query
     * @param $multipleFields//排序json{"sort_key":"id","sort_order":"desc"}
     * @return mixed
     */
    public function getMultipleFieldsQuery($query, $multipleFields)
    {
        if (!$multipleFields) {
            return $query;
        }

        $sortFields = json_decode($multipleFields, true);

        if (!$sortFields) {
            return $query;
        }

        foreach ($sortFields as $sortField) {

            if (isset($sortField['sort_key']) && $sortField['sort_key']) {
                $sortOrder = 'desc';
                if (isset($sortField['sort_order']) && $sortField['sort_order']) {
                    $sortOrder = $sortField['sort_order'];
                }
                $query = $query->orderBy($sortField['sort_key'], $sortOrder);
            }
        }

        return $query;
    }
}
