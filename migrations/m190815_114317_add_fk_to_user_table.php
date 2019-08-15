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

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190815_114317_add_fk_to_user_table cannot be reverted.\n";

        return false;
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
