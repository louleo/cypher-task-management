<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%list}}`.
 */
class m190818_024503_create_list_table extends \app\components\VersionedMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createVersionTable('list', [
            'id' => $this->primaryKey(),
            'board_id'=>'int(11) not null',
            'name'=>'varchar(255) not null',
            'order'=>'int(3) not null',
        ]);
        $this->addForeignKey('fk_list_board_id','list','board_id','board','id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_list_board_id','list');
        $this->dropVersionTable('list');
    }
}
