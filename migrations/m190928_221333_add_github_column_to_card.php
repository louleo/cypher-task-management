<?php

use yii\db\Migration;

/**
 * Class m190928_221333_add_github_column_to_card
 */
class m190928_221333_add_github_column_to_card extends \app\components\VersionedMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addVersionColumn('card','github_pr_link','text');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropVersionColumn('card','github_pr_link');
    }
}
