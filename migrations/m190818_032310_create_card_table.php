<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%card}}`.
 */
class m190818_032310_create_card_table extends \app\components\VersionedMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createVersionTable('card', [
            'id' => $this->primaryKey(),
            'list_id'=>'int(11) not null',
            'title'=>'varchar(255) not null',
            'code' => 'varchar(255) not null',
            'description'=>'text',
            'due_date'=>'datetime',
            'start_date'=>'datetime',
            'end_date'=>'datetime',
            'total_used_time'=>'varchar(255)',
        ]);

        $this->addForeignKey('fk_card_list_id','card','list_id','list','id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_card_list_id','card');
        $this->dropVersionTable('card');
    }
}
