<?php

use yii\db\Migration;

/**
 * Class m190816_085110_init_rbac
 */
class m190816_085110_init_rbac extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $auth = Yii::$app->authManager;

        $admin = $auth->createPermission('admin');
        $admin->description = 'Administration';
        $auth->add($admin);

        $auth->assign($admin,1);
    }

    public function down()
    {
        echo "m190816_085110_init_rbac cannot be reverted.\n";

        return true;
    }

}
