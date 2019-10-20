<?php

use yii\db\Migration;
use app\components\VersionedMigration;

/**
 * Class m191020_095142_drop_board_lists_fk
 */
class m191020_095142_drop_board_lists_fk extends VersionedMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('fk_board_start_list_id','board');
        $this->dropForeignKey('fk_board_end_list_id','board');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addForeignKey('fk_board_start_list_id','board','start_list_id','list','id');
        $this->addForeignKey('fk_board_end_list_id','board','end_list_id','list','id');
    }
}
