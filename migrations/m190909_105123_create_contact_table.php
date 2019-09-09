<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%contact}}`.
 */
class m190909_105123_create_contact_table extends \app\components\VersionedMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createVersionTable('contact', [
            'id' => $this->primaryKey(),
            'first_name'=>'varchar(255) not null',
            'last_name'=>'varchar(255) not null',
            'email'=>'varchar(255)',
            'mobile'=>'varchar(255)',
            'nick_name'=>'varchar(15) not null',
            'user_id'=> 'int(11) not null',
        ]);
        $this->addForeignKey('fk_contact_user_id','contact','user_id','user','id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_contact_user_id','contact');
        $this->dropVersionTable('contact');
    }
}
