<?php

namespace Miaoxing\ProductTag\Controller\Admin;

class Tag extends \miaoxing\plugin\BaseController
{
    protected $controllerName = '标签管理';

    protected $actionPermissions = [
        'index' => '列表',
        'new,create' => '添加',
        'edit,update' => '编辑',
        'destroy' => '删除',
    ];

    public function indexAction($req)
    {
        switch ($req['_format']) {
            case 'json':
                $tags = wei()->tag();

                // 分页
                $tags->limit($req['rows'])->page($req['page']);

                // 排序
                $tags->desc('sort')->desc('id');

                // 搜索
                if ($req['search']) {
                    $tags->andWhere('name LIKE ?', '%' . $req['search'] . '%');
                }

                // 分类筛选
                if ($req['categoryId']) {
                    $tags->andWhere('categoryId = ?', $req['categoryId']);
                }

                $data = array();
                foreach ($tags as $tag) {
                    $data[] = $tag->toArray();
                }

                return $this->json('读取列表成功', 1, array(
                    'data' => $data,
                    'page' => $req['page'],
                    'rows' => $req['rows'],
                    'records' => $tags->count(),
                ));

            default:
                return get_defined_vars();
        }
    }

    public function newAction()
    {
        $tag = wei()->tag();
        return get_defined_vars();
    }

    public function createAction($req)
    {
        return $this->updateAction($req);
    }

    public function editAction($req)
    {
        $tag = wei()->tag()->findOne($req['id']);
        return get_defined_vars();
    }

    public function updateAction($req)
    {
        $tag = wei()->tag()->findOrInitById($req['id'])->fromArray($req)->save();
        return $this->json('操作成功', 1, ['data' => $tag->toArray()]);
    }

    public function destroyAction($req)
    {
        wei()->tag()->findOne($req['id'])->destroy();
        return $this->suc();
    }
}
