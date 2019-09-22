<?php

namespace app\models;

use Yii;
use yii\helpers\Json;

/**
 * This is the model class for table "note".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $is_public
 * @property int $last_modified_user_id
 * @property string $last_modified_date
 * @property int $created_user_id
 * @property string $created_date
 * @property int $active
 *
 * @property NoteContent[] $noteContents
 */
class Note extends \app\models\ActiveRecordVersion
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'note';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description', 'is_public'], 'required'],
            [['description'], 'string'],
            [['is_public', 'last_modified_user_id', 'created_user_id', 'active'], 'integer'],
            [['last_modified_date', 'created_date'], 'safe'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'is_public' => 'Public',
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
    public function getNoteContents()
    {
        return $this->hasMany(NoteContent::className(), ['note_id' => 'id'])->orderBy(['order'=> SORT_ASC]);
    }

    public function getCreatedUser(){
        return $this->hasOne(User::className(),['id'=>'created_user_id']);
    }

    public function canEdit(){
        if (Yii::$app->user->can('admin') || $this->created_user_id == Yii::$app->user->id){
            return true;
        }
        return false;
    }

    public function noteContentsToJson(){
        if (isset($this->noteContents)){
            $returnArray = [];
            foreach ($this->noteContents as $noteContent){
                $returnArray[$noteContent->id] = $noteContent->content;
            }
            return str_replace('\\','\\\\',Json::encode($returnArray));
        }
    }

    public function noteContentOrder(){
        return count($this->noteContents) + 1;
    }
}