<?php


class VersionMigration extends \yii\db\Migration
{
    /**
     * Create a table with the standard columns.
     *
     * @param string $name
     * @param array  $columns
     */
    protected function createVersionTable($name, array $columns)
    {
        $fk_prefix = substr($name, 0, 56);
        $columns = array_merge(
            $columns,
            array(
                'last_modified_user_id' => 'int unsigned not null default 1',
                'last_modified_date' => 'datetime not null default "1901-01-01 00:00:00"',
                'created_user_id' => 'int unsigned not null default 1',
                'created_date' => 'datetime not null default "1901-01-01 00:00:00"',
                "constraint {$fk_prefix}_lmui_fk foreign key (last_modified_user_id) references user (id)",
                "constraint {$fk_prefix}_cui_fk foreign key (created_user_id) references user (id)",
            )
        );
        $this->createTable($name, $columns, 'engine=InnoDB charset=utf8 collate=utf8_unicode_ci');
            foreach ($columns as $n => &$column) {
                if ($column == 'pk') {
                    $column = 'integer not null';
                }
                if (preg_match('/^constraint/i', $column)) {
                    unset($columns[$n]);
                }
                $column = str_ireplace(' unique', '', $column);
            }
            $columns = array_merge(
                $columns,
                array(
                    'version_date' => 'datetime not null',
                    'version_id' => 'pk',
                )
            );
            $this->createTable("{$name}_version", $columns, 'engine=InnoDB charset=utf8 collate=utf8_unicode_ci');
    }

    /**
     * Convenience function to drop versioned table from db
     *
     * @param      $name
     */
    protected function dropVersionTable($name)
    {
        $this->dropTable("{$name}_version");
        $this->dropTable($name);
    }
}