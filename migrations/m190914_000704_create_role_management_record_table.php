<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%role_management_record}}`.
 */
class m190914_000704_create_role_management_record_table extends \app\components\VersionedMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createVersionTable('role_management_records', [
            'id' => $this->primaryKey(),
            'user_id'=>'int(11) not null',
            'item_name'=>'varchar(64) not null',
            'action'=>'varchar(64) not null',
        ]);

        $this->addForeignKey('fk_rm_records_user_id','role_management_records','user_id','user','id');
        $this->addForeignKey('fk_rm_records_item_name','role_management_records','item_name','auth_item','name');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_rm_records_user_id','role_management_records');
        $this->dropForeignKey('fk_rm_records_item_name','role_management_records');
        $this->dropVersionTable('role_management_records');
    }
}
