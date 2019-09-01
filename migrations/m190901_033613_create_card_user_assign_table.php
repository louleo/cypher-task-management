<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%card_user_assign}}`.
 */
class m190901_033613_create_card_user_assign_table extends \app\components\VersionedMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createVersionTable('card_user_assign', [
            'id' => $this->primaryKey(),
            'user_id'=>'int(11) not null',
            'card_id'=>'int(11) not null',
        ]);

        $this->addForeignKey('fk_cua_user_id','card_user_assign','user_id','user','id');
        $this->addForeignKey('fk_cua_card_id','card_user_assign','card_id','card','id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_cua_user_id','card_user_assign');
        $this->dropForeignKey('fk_cua_card_id','card_user_assign');
        $this->dropVersionTable('card_user_assign');
    }
}
