<?php

use yii\db\Migration;

/**
 * Class m190818_010153_add_create_board_role
 */
class m190818_010153_add_create_board_role extends Migration
{

    public function up()
    {
        $auth = Yii::$app->authManager;

        $createBoard = $auth->createPermission('createBoard');
        $createBoard->description = 'Board Creation';
        $auth->add($createBoard);

        $auth->assign($createBoard,1);
    }

    public function down()
    {
        echo "m190818_010153_add_board_role cannot be reverted.\n";

        return true;
    }

}
