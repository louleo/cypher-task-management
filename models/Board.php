<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "board".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $description
 * @property int $last_modified_user_id
 * @property string $last_modified_date
 * @property int $created_user_id
 * @property string $created_date
 * @property int $active
 *
 * @property BoardUserAssign[] $boardUserAssigns
 */
class Board extends \app\models\ActiveRecordVersion
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'board';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name','code'], 'required'],
            [['description','github_repo'], 'string'],
            [['last_modified_user_id', 'created_user_id', 'active'], 'integer'],
            [['last_modified_date', 'created_date'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'code' => 'Board Code',
            'description' => 'Description',
            'last_modified_user_id' => 'Last Modified User ID',
            'last_modified_date' => 'Last Modified Date',
            'created_user_id' => 'Created User ID',
            'created_date' => 'Created Date',
            'github_repo'=>'Github Link',
            'active' => 'Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBoardUserAssigns()
    {
        return $this->hasMany(BoardUserAssign::className(), ['board_id' => 'id']);
    }

    public static function getDefaultBoard($userId){
        $boardUserAssign = BoardUserAssign::findOne(['user_id'=>$userId]);
        if (isset($boardUserAssign)){
            return $boardUserAssign->board;
        }else{
            $boardUserCreation = Board::findOne(['created_user_id'=>$userId]);
            if (isset($boardUserCreation)){
                return $boardUserCreation;
            }
            return false;
        }
    }

    public function beforesave($insert)
    {
        $this->code = strtoupper($this->code);
        return parent::beforesave($insert);
    }

    public function isAdmin($userId){
        return self::adminCheck($userId,$this->id);
    }

    public static function adminCheck($userId,$boardId){
        $boardUserAssign = BoardUserAssign::findOne(['board_id'=>$boardId,'user_id'=>$userId,'is_admin'=>'1']);
        if (isset($boardUserAssign) || Yii::$app->user->can('admin')){
            return true;
        }
        return false;
    }

    public static function userCheck($userId, $boardId){
        $boardUserAssign = BoardUserAssign::findOne(['board_id'=>$boardId,'user_id'=>$userId]);
        if (isset($boardUserAssign) || Yii::$app->user->can('admin')){
            return true;
        }
        return false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLists()
    {
        return $this->hasMany(BoardList::className(), ['board_id' => 'id'])->where(['active'=>1])->orderBy(['order'=>SORT_ASC]);
    }

    public function isUser($userId){
        return self::userCheck($userId,$this->id);
    }

    public function getBoardUsers(){
        return $this->hasMany(User::className(),['id'=>'user_id'])->viaTable('board_user_assign',['board_id'=>'id']);
    }

    public function createNewBoardUserAssign(){
        $returnModel = new BoardUserAssign();
        $returnModel->board_id = $this->id;
        return $returnModel;
    }
}