<?php

namespace Miaoxing\ProductTag;

use Miaoxing\Product\Service\Product;
use Miaoxing\ProductTag\Service\Tag;

class Plugin extends \miaoxing\plugin\BasePlugin
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
            ->andWhere("recordTag.recordTable = 'product'")
            ->andWhere(['recordTag.tagId' => $tags])
            ->groupBy('product.id');

        if (wei()->setting('products.tagQueryType') == Tag::QUERY_TYPE_ALL) {
            $products->having('COUNT(DISTINCT recordTag.id) = ?', count($tags));
        }
    }

    public function onAdminProductsEdit()
    {
        $this->view->display('@product-tag/tag/adminProductsEdit.php');
    }
}
