<?php


use yii\db\ColumnSchemaBuilder;

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
    /**
     * Builds and executes a SQL statement for adding a new DB column.
     * @param string $table the table that the new column will be added to. The table name will be properly quoted by the method.
     * @param string $column the name of the new column. The name will be properly quoted by the method.
     * @param string $type the column type. The [[QueryBuilder::getColumnType()]] method will be invoked to convert abstract column type (if any)
     * into the physical one. Anything that is not recognized as abstract type will be kept in the generated SQL.
     * For example, 'string' will be turned into 'varchar(255)', while 'string not null' will become 'varchar(255) not null'.
     */
    public function addVersionColumn($table, $column, $type)
    {
        $time = $this->beginCommand("add column $column $type to table $table");
        $this->db->createCommand()->addColumn($table, $column, $type)->execute();
        $this->db->createCommand()->addColumn($table."_version",$column,$type)->execute();
        if ($type instanceof ColumnSchemaBuilder && $type->comment !== null) {
            $this->db->createCommand()->addCommentOnColumn($table, $column, $type->comment)->execute();
            $this->db->createCommand()->addCommentOnColumn("{$table}_version", $column, $type->comment)->execute();
        }
        $this->endCommand($time);
    }

    /**
     * Builds and executes a SQL statement for dropping a DB column.
     * @param string $table the table whose column is to be dropped. The name will be properly quoted by the method.
     * @param string $column the name of the column to be dropped. The name will be properly quoted by the method.
     */
    public function dropVersionColumn($table, $column)
    {
        $time = $this->beginCommand("drop column $column from table $table");
        $this->db->createCommand()->dropColumn($table, $column)->execute();
        $this->db->createCommand()->dropColumn("{$table}_version",$column)->execute();
        $this->endCommand($time);
    }

    /**
     * Builds and executes a SQL statement for renaming a column.
     * @param string $table the table whose column is to be renamed. The name will be properly quoted by the method.
     * @param string $name the old name of the column. The name will be properly quoted by the method.
     * @param string $newName the new name of the column. The name will be properly quoted by the method.
     */
    public function renameVersionColumn($table, $name, $newName)
    {
        $time = $this->beginCommand("rename column $name in table $table to $newName");
        $this->db->createCommand()->renameColumn($table, $name, $newName)->execute();
        $this->db->createCommand()->renameColumn("{$table}_version", $name, $newName)->execute();
        $this->endCommand($time);
    }

    /**
     * Builds and executes a SQL statement for changing the definition of a column.
     * @param string $table the table whose column is to be changed. The table name will be properly quoted by the method.
     * @param string $column the name of the column to be changed. The name will be properly quoted by the method.
     * @param string $type the new column type. The [[QueryBuilder::getColumnType()]] method will be invoked to convert abstract column type (if any)
     * into the physical one. Anything that is not recognized as abstract type will be kept in the generated SQL.
     * For example, 'string' will be turned into 'varchar(255)', while 'string not null' will become 'varchar(255) not null'.
     */
    public function alterVersionColumn($table, $column, $type)
    {
        $time = $this->beginCommand("alter column $column in table $table to $type");
        $this->db->createCommand()->alterColumn($table, $column, $type)->execute();
        $this->db->createCommand()->alterColumn("{$table}_version", $column, $type)->execute();
        if ($type instanceof ColumnSchemaBuilder && $type->comment !== null) {
            $this->db->createCommand()->addCommentOnColumn($table, $column, $type->comment)->execute();
            $this->db->createCommand()->addCommentOnColumn("{$table}_version", $column, $type->comment)->execute();
        }
        $this->endCommand($time);
    }

}