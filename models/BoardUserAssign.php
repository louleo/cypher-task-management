<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "board_user_assign".
 *
 * @property int $id
 * @property int $user_id
 * @property int $board_id
 * @property int $last_modified_user_id
 * @property string $last_modified_date
 * @property int $created_user_id
 * @property string $created_date
 * @property int $active
 *
 * @property Board $board
 * @property User $user
 */
class BoardUserAssign extends \app\models\ActiveRecordVersion
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'board_user_assign';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'board_id'], 'required'],
            [['user_id', 'board_id', 'last_modified_user_id', 'created_user_id', 'active'], 'integer'],
            [['last_modified_date', 'created_date'], 'safe'],
            [['board_id'], 'exist', 'skipOnError' => true, 'targetClass' => Board::className(), 'targetAttribute' => ['board_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'board_id' => 'Board ID',
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
    public function getBoard()
    {
        return $this->hasOne(Board::className(), ['id' => 'board_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}