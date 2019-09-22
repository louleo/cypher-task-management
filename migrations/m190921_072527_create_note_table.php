<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%note}}`.
 */
class m190921_072527_create_note_table extends \app\components\VersionedMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createVersionTable('note', [
            'id' => $this->primaryKey(),
            'title'=>'varchar(255) not null',
            'description'=>'TEXT not null',
            'is_public'=>'tinyint(1) not null',
        ]);

        $this->createVersionTable('note_content',[
            'id'=>$this->primaryKey(),
            'title'=>'varchar(255) not null',
            'content'=>'MEDIUMTEXT not null',
            'note_id'=>'int(11) not null',
            'order'=>'int(11) not null',
        ]);

        $this->addForeignKey('fk_note_content_note_id','note_content','note_id','note','id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_note_content_note_id','note_content');
        $this->dropVersionTable('note_content');
        $this->dropVersionTable('note');
    }
}
