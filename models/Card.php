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
            [['list_id','code', 'last_modified_user_id', 'created_user_id', 'active'], 'integer'],
            [['description','github_pr_link'], 'string'],
            [['due_date', 'start_date', 'end_date', 'last_modified_date', 'created_date'], 'safe'],
            [['title', 'total_used_time'], 'string', 'max' => 255],
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
            'github_pr_link'=>'Github Pathway',
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

    public function initCode(){
        $currentList = $this->list;
        $currentBoard = $currentList->board;
        $code = 1;
        foreach ($currentBoard->lists as $curList){
            $newestCard = Card::find(['list_id'=>$curList->id])->orderBy(['code'=>SORT_DESC])->one();
            if (isset($newestCard)){
                if ($code <= $newestCard->code){
                    $code = $newestCard->code +1;
                }
            }
        }
        return $code;
    }

    public function getBoardCode(){
        $currentList = $this->list;
        $currentBoard = $currentList->board;
        return $currentBoard->code.'-'.$this->code;
    }

    public function getCreator(){
        return $this->hasOne(User::className(),['id'=>'created_user_id']);
    }

    public function getComments(){
        return $this->hasMany(Comment::className(),['card_id'=>'id'])->orderBy(['last_modified_date'=>SORT_DESC]);
    }

    public function moveTo($list_id){
        $this->list_id = $list_id;

        $list = BoardList::find()->where(['id'=>$list_id])->one();
        if (isset($list)){

            $board = $list->board;
            if ($board->start_list_id == $list->id){
                $this->start_date = date('Y-m-d H:i:s');;
            }elseif ($board->end_list_id == $list->id){
                $this->end_date = date('Y-m-d H:i:s');;
            }
        }
        return $this->save();
    }

    public function getBoardLists(){
        if (isset($this->list)){
            $list = $this->list;
            if (isset($list->board)){
                return $list->board->lists;
            }
        }
        return null;
    }

    public function getNewComment(){
        return new Comment();
    }

    public function getAssignee(){
        return $this->hasOne(User::className(),['id'=>'user_id'])->viaTable('card_user_assign',['card_id'=>'id'])->where(['active'=>1]);
    }

    public function getBoardUsers(){
        if (isset($this->list)){
            $list = $this->list;
            if (isset($list->board)){
                return $list->board->boardUsers;
            }
        }
        return null;
    }

    public function getBoardUsersOptions(){
        $users = $this->getBoardUsers();
        $return = ['0'=>'------Select------'];
        if (isset($users)){
           foreach ($users as $user){
               $return[$user->id] = $user->userName;
           }
           return $return;
        }
        return null;
    }

    public function assignTo($user_id){
        $user = User::find()->where(['id'=>$user_id])->one();
        if (isset($user)){
            $cardUserAssign = isset($this->cardUserAssign)? $this->cardUserAssign : new CardUserAssign();
            $cardUserAssign->card_id = $this->id;
            $cardUserAssign->user_id = $user_id;
            return $cardUserAssign->save();
        }else{
            if (isset($this->cardUserAssign)){
                return $this->cardUserAssign->delete();
            }
        }
        return false;
    }

    public function getNewAssignee(){
        return new CardUserAssign();
    }

    public function getCardUserAssign(){
        return $this->hasOne(CardUserAssign::className(),['card_id'=>'id'])->where(['active'=>1]);
    }

    public function beforesave($insert)
    {
        /* may not be used at current stage
        if (isset($this->end_date) && preg_match("/^(0[1-9]|1[0-2])\/(0[1-9]|[1-2][0-9]|3[0-1])\/[0-9]{4}$/",$this->end_date)){
            $this->dateFormat('end_date');
        }else{
            $this->end_date = null;
        }
        if (isset($this->start_date) && preg_match("/^(0[1-9]|1[0-2])\/(0[1-9]|[1-2][0-9]|3[0-1])\/[0-9]{4}$/",$this->start_date)){
            $this->dateFormat('start_date');
        }else{
            $this->start_date = null;
        }
        */
        if (isset($this->due_date) && preg_match("/^(0[1-9]|1[0-2])\/(0[1-9]|[1-2][0-9]|3[0-1])\/[0-9]{4}$/",$this->due_date)){
            $this->dateFormat('due_date');
        }else{
            $this->due_date = null;
        }
        return parent::beforesave($insert);
    }
}