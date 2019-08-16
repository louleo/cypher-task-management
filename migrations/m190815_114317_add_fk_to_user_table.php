<?php

use yii\db\Migration;

/**
 * Class m190815_114317_add_fk_to_user_table
 */
class m190815_114317_add_fk_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('fk_created_user_id','user','created_user_id','user','id');
        $this->addForeignKey('fk_last_modified_user_id','user','last_modified_user_id','user','id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_created_user_id','user');
        $this->dropForeignKey('fk_last_modified_user_id','user');
//        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190815_114317_add_fk_to_user_table cannot be reverted.\n";

        return false;
    }
    */
}
