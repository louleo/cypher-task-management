<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%team}}`.
 */
class m190817_043417_create_team_table extends \app\components\VersionedMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createVersionTable('team', [
            'id' => $this->primaryKey(),
            'name'=>'varchar(255) not null',
            'description' => 'text'
        ]);

        $this->createVersionTable('team_user_assign',[
            'id'=>$this->primaryKey(),
            'team_id'=>'int(11) not null',
            'user_id'=>'int(11) not null',
        ]);

        $this->createVersionTable('team_board_assign',[
            'id'=>$this->primaryKey(),
            'team_id'=>'int(11) not null',
            'board_id' => 'int(11) not null',
        ]);

        $this->addForeignKey('fk_team_user_team_id','team_user_assign','team_id','team','id');
        $this->addForeignKey('fk_team_user_user_id','team_user_assign','user_id','user','id');
        $this->addForeignKey('fk_team_board_team_id','team_board_assign','team_id','team','id');
        $this->addForeignKey('fk_team_board_board_id','team_board_assign','board_id','board','id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_team_board_team_id','team_board_assign');
        $this->dropForeignKey('fk_team_board_board_id','team_board_assign');
        $this->dropForeignKey('fk_team_user_team_id','team_user_assign');
        $this->dropForeignKey('fk_team_user_user_id','team_user_assign');
        $this->dropVersionTable('team_board_assign');
        $this->dropVersionTable('team_user_assign');
        $this->dropVersionTable('team');
    }
}
