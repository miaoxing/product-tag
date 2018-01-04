<?php

namespace Miaoxing\ProductTag\Service;

class Tag extends \Miaoxing\Plugin\BaseModel
{
    /**
     * 查询时,显示包含所有标签的商品
     */
    const QUERY_TYPE_ALL = 0;

    /**
     * 查询时,显示包含任意标签的商品
     */
    const QUERY_TYPE_ANY = 1;

    protected $enableTrash = true;

    protected $data = [
        'sort' => 50,
    ];
}
