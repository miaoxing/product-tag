<?php

namespace Miaoxing\ProductTag;

use Miaoxing\Product\Service\Product;
use Miaoxing\ProductTag\Service\Tag;

class Plugin extends \Miaoxing\Plugin\BasePlugin
{
    protected $name = '商品标签';

    protected $description = '为商品增加标签功能';

    protected $adminNavId = 'products';

    public function onAdminNavGetNavs(&$navs, &$categories, &$subCategories)
    {
        $navs[] = [
            'parentId' => 'products-service',
            'url' => 'admin/tag/index',
            'name' => '标签管理',
        ];
    }

    public function onLinkToGetLinks(&$links, &$types)
    {
        foreach (wei()->tag()->desc('sort')->fetchAll() as $tag) {
            $links[] = [
                'typeId' => 'mall',
                'name' => '商品标签：' . $tag['name'],
                'url' => 'products?tags=' . $tag['id'],
            ];
        }
    }

    /**
     * 按标签筛选
     *
     * @param $req
     * @param Product $products
     */
    public function onPreProductListFind($req, Product $products)
    {
        $tags = $req['tags'] ? explode(',', $req['tags']) : [];
        if (!$tags) {
            return;
        }

        $products
            ->select('DISTINCT product.*')
            ->leftJoin('recordTag', 'product.id = recordTag.recordId')
            ->andWhere(['recordTag.tagId' => $tags])
            ->groupBy('product.id');

        // 如果是有标签,未排序,改为按标签加入时间排序
        if (!$req['sort'] || $req['sort'] === 'default') {
            $products->orderBy('recordTag.createTime', 'DESC');
        }

        if (wei()->setting('products.tagQueryType') == Tag::QUERY_TYPE_ALL) {
            $products->having('COUNT(DISTINCT recordTag.id) = ?', count($tags));
        }
    }

    public function onAdminProductsEdit()
    {
        $this->view->display('@product-tag/tag/adminProductsEdit.php');
    }
}
