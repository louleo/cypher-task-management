<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%board}}`.
 */
class m190817_043030_create_board_table extends \app\components\VersionedMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createVersionTable('board', [
            'id' => $this->primaryKey(),
            'name' => 'varchar(255) not null',
            'description' => 'text',
        ]);
        $this->createVersionTable('board_user_assign',[
            'id'=>$this->primaryKey(),
            'user_id'=>'int(11) not null',
            'board_id'=>'int(11) not null',
        ]);

        $this->addForeignKey('fk_board_user_user_id','board_user_assign','user_id','user','id');
        $this->addForeignKey('fk_board_user_board_id','board_user_assign','board_id','board','id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_board_user_user_id','board_user_assign');
        $this->dropForeignKey('fk_board_user_board_id','board_user_assign');
        $this->dropVersionTable('board_user_assign');
        $this->dropVersionTable('board');
    }
}
