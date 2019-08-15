<?php

use yii\db\Migration;

/**
 * Class m190815_062359_user_table
 */
class m190815_062359_user_table extends VersionMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createVersionTable('user',
            array('id' => 'int NOT NULL AUTO_INCREMENT',
                'user_number' => 'varchar(255) NOT NULL',
                'user_name' => 'varchar(255)',
                'dob' => 'DATE NOT NULL',
                'password' => 'varchar(255)',
                'PRIMARYKEY'
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190815_062359_user_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190815_062359_user_table cannot be reverted.\n";

        return false;
    }
    */
}
