<?php

use yii\db\Migration;
use app\components\VersionedMigration;

/**
 * Class m191020_101024_change_card_code_type
 */
class m191020_101024_change_card_code_type extends VersionedMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterVersionColumn('card', 'code', 'int(11)');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterVersionColumn('card', 'code', 'varchar(255)');
    }

}
