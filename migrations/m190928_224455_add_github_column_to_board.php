<?php

use yii\db\Migration;

/**
 * Class m190928_224455_add_github_column_to_board
 */
class m190928_224455_add_github_column_to_board extends \app\components\VersionedMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addVersionColumn('board','github_repo','text');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropVersionColumn('board','github_repo');
    }

}
