<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%comment}}`.
 */
class m190901_033018_create_comment_table extends \app\components\VersionedMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createVersionTable('comment', [
            'id' => $this->primaryKey(),
            'content'=>'text not null',
            'card_id'=>'int(11) not null'
        ]);

        $this->addForeignKey('fk_comment_card_id','comment','card_id','card','id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_comment_card_id','comment');
        $this->dropVersionTable('comment');
    }
}
