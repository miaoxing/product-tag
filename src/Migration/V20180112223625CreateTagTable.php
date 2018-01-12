<?php

namespace Miaoxing\ProductTag\Migration;

use Miaoxing\Plugin\BaseMigration;

class V20180112223625CreateTagTable extends BaseMigration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->schema->table('tag')
            ->id()
            ->string('recordTable', 32)
            ->string('name', 32)
            ->string('color', 16)
            ->int('sort')->defaults(50)
            ->bool('enable')->defaults(true)
            ->int('createUser')
            ->datetime('createTime')
            ->int('updateUser')
            ->datetime('updateTime')
            ->exec();
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->schema->dropIfExists('tag');
    }
}
