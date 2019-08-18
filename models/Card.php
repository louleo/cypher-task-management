<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "card".
 *
 * @property int $id
 * @property int $list_id
 * @property string $title
 * @property string $code
 * @property string $description
 * @property string $due_date
 * @property string $start_date
 * @property string $end_date
 * @property string $total_used_time
 * @property int $last_modified_user_id
 * @property string $last_modified_date
 * @property int $created_user_id
 * @property string $created_date
 * @property int $active
 *
 * @property List $list
 */
class Card extends \app\models\ActiveRecordVersion
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'card';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['list_id', 'title', 'code'], 'required'],
            [['list_id', 'last_modified_user_id', 'created_user_id', 'active'], 'integer'],
            [['description'], 'string'],
            [['due_date', 'start_date', 'end_date', 'last_modified_date', 'created_date'], 'safe'],
            [['title', 'code', 'total_used_time'], 'string', 'max' => 255],
            [['list_id'], 'exist', 'skipOnError' => true, 'targetClass' => BoardList::className(), 'targetAttribute' => ['list_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'list_id' => 'List ID',
            'title' => 'Title',
            'code' => 'Code',
            'description' => 'Description',
            'due_date' => 'Due Date',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'total_used_time' => 'Total Used Time',
            'last_modified_user_id' => 'Last Modified User ID',
            'last_modified_date' => 'Last Modified Date',
            'created_user_id' => 'Created User ID',
            'created_date' => 'Created Date',
            'active' => 'Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getList()
    {
        return $this->hasOne(BoardList::className(), ['id' => 'list_id']);
    }
}