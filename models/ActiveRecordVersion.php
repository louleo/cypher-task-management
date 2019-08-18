<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\models;

use Yii;
use yii\base\InvalidArgumentException;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;
use yii\db\BaseActiveRecord;

class ActiveRecordVersion extends ActiveRecord
{
    /**
     * The insert operation. This is mainly used when overriding [[transactions()]] to specify which operations are transactional.
     */
    const OP_INSERT = 0x01;
    /**
     * The update operation. This is mainly used when overriding [[transactions()]] to specify which operations are transactional.
     */
    const OP_UPDATE = 0x02;
    /**
     * The delete operation. This is mainly used when overriding [[transactions()]] to specify which operations are transactional.
     */
    const OP_DELETE = 0x04;
    /**
     * All three operations: insert, update, delete.
     * This is a shortcut of the expression: OP_INSERT | OP_UPDATE | OP_DELETE.
     */
    const OP_ALL = 0x07;

    /**
     * Updates the whole table using the provided attribute values and conditions.
     *
     * For example, to change the status to be 1 for all customers whose status is 2:
     *
     * ```php
     * Customer::updateAll(['status' => 1], 'status = 2');
     * ```
     *
     * > Warning: If you do not specify any condition, this method will update **all** rows in the table.
     *
     * Note that this method will not trigger any events. If you need [[EVENT_BEFORE_UPDATE]] or
     * [[EVENT_AFTER_UPDATE]] to be triggered, you need to [[find()|find]] the models first and then
     * call [[update()]] on each of them. For example an equivalent of the example above would be:
     *
     * ```php
     * $models = Customer::find()->where('status = 2')->all();
     * foreach ($models as $model) {
     *     $model->status = 1;
     *     $model->update(false); // skipping validation as no user input is involved
     * }
     * ```
     *
     * For a large set of models you might consider using [[ActiveQuery::each()]] to keep memory usage within limits.
     *
     * @param array $attributes attribute values (name-value pairs) to be saved into the table
     * @param string|array $condition the conditions that will be put in the WHERE part of the UPDATE SQL.
     * Please refer to [[Query::where()]] on how to specify this parameter.
     * @param array $params the parameters (name => value) to be bound to the query.
     * @return int the number of rows updated
     */
    public static function updateAll($attributes, $condition = '', $params = [])
    {

        static::updateToVersionTable($condition,$params);
        $command = static::getDb()->createCommand();
        $command->update(static::tableName(), $attributes, $condition, $params);

        return $command->execute();
    }

    /**
     * Declares the name of the database table associated with this AR class.
     * By default this method returns the class name as the table name by calling [[Inflector::camel2id()]]
     * with prefix [[Connection::tablePrefix]]. For example if [[Connection::tablePrefix]] is `tbl_`,
     * `Customer` becomes `tbl_customer`, and `OrderItem` becomes `tbl_order_item`. You may override this method
     * if the table is not named after this convention.
     * @return string the table name
     */
    public static function tableName()
    {
        return '{{%' . Inflector::camel2id(StringHelper::basename(get_called_class()), '_') . '}}';
    }

    public static function versionTableName(){
        return substr(self::tableName(),0,-2).'_version}}';
    }
    /**
     * Inserts an ActiveRecord into DB without considering transaction.
     * @param array $attributes list of attributes that need to be saved. Defaults to `null`,
     * meaning all attributes that are loaded from DB will be saved.
     * @return bool whether the record is inserted successfully.
     */
    protected function insertInternal($attributes = null)
    {
        if (!$this->beforeSave(true)) {
            return false;
        }
        $values = $this->getDirtyAttributes($attributes);
        if (($primaryKeys = static::getDb()->schema->insert(static::tableName(), $values)) === false) {
            return false;
        }
        foreach ($primaryKeys as $name => $value) {
            $id = static::getTableSchema()->columns[$name]->phpTypecast($value);
            $this->setAttribute($name, $id);
            $values[$name] = $id;
        }
        $this->insertToVersionTable(static::versionTableName(),$values);
        $changedAttributes = array_fill_keys(array_keys($values), null);
        $this->setOldAttributes($values);
        $this->afterSave(true, $changedAttributes);

        return true;
    }

    protected static function insertToVersionTable($table,$columns)
    {
        $command = static::getDb()->createCommand()->insert($table, $columns);
        return $command->execute();
    }

    protected static function updateToVersionTable($condition = '', $params = [])
    {
        $tableName = static::tableName();
        $queryOldAttributes = implode(', ', array_map(
            function ($v, $k) {
                    return $k.' = '.$v;
            },
            $condition,
            array_keys($condition)
        ));
        $oldAttributes = static::getDb()->createCommand("SELECT * FROM {$tableName} WHERE {$queryOldAttributes}")->queryOne();
        $oldAttributes['version_date'] = date('Y-m-d H:i:s');
        $versionTableUpdate = static::getDb()->createCommand()->update(static::versionTableName(),$oldAttributes,$condition,$params);
        return $versionTableUpdate->execute();
    }

    public function beforesave($insert){
        $this->last_modified_user_id = Yii::$app->user->id;
        $this->last_modified_date = date('Y-m-d H:i:s');
        if (!isset($this->creted_date) || empty($this->created_date)){
            $this->created_date = date('Y-m-d H:i:s');
        }
        if (!isset($this->created_user_id) || empty($this->created_user_id)){
            $this->created_user_id = Yii::$app->user->id;
        }
        return parent::beforeSave($insert);
    }

    public function deactivate(){
        if ($this->active == 1){
            $this->active = 0;
            $this->save();
        }else{
            $this->active = 1;
            $this->save();
        }
    }
}
