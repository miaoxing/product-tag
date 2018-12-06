<?php

namespace Miaoxing\ProductTag\Migration;

use Miaoxing\Plugin\BaseMigration;

class V20180122102456CreateRecordTagTable extends BaseMigration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->schema->table('recordTag')
            ->id()
            ->int('tagId')
            ->int('recordId')
            ->string('recordTable', 32)
            ->datetime('createTime')
            ->int('createUser')
            ->datetime('updateTime')
            ->int('updateUser')
            ->exec();
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->schema->dropIfExists('recordTag');
    }
}
