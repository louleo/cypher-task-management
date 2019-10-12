<?php

use yii\db\Migration;

/**
 * Class m191012_093201_board_start_end_list
 */
class m191012_093201_board_start_end_list extends \app\components\VersionedMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addVersionColumn('board','start_list_id','int(11)');
        $this->addVersionColumn('board','end_list_id','int(11)');

        $this->addForeignKey('fk_board_start_list_id','board','start_list_id','list','id');
        $this->addForeignKey('fk_board_end_list_id','board','end_list_id','list','id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_board_start_list_id','board');
        $this->dropForeignKey('fk_board_end_list_id','board');

        $this->dropVersionColumn('board','start_list_id');
        $this->dropVersionColumn('board','end_list_id');
    }
}
