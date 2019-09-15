<?php

//use yii\db\Migration;
/**
 * Class m190815_062359_user_table
 */
class m190815_062359_user_table extends app\components\VersionedMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createVersionTable('user',
            array('id' => 'pk',
                'user_number' => 'varchar(255) NOT NULL',
                'user_name' => 'varchar(255)',
                'dob' => 'DATE NOT NULL',
                'password' => 'varchar(255)',
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropVersionTable('user');
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
