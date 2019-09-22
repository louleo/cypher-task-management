<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "note_content".
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property int $note_id
 * @property int $last_modified_user_id
 * @property string $last_modified_date
 * @property int $created_user_id
 * @property string $created_date
 * @property int $active
 *
 * @property Note $note
 */
class NoteContent extends \app\models\ActiveRecordVersion
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'note_content';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content', 'note_id','order','title'], 'required'],
            [['content'], 'string'],
            [['note_id', 'last_modified_user_id', 'created_user_id', 'active','order'], 'integer'],
            [['last_modified_date', 'created_date'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['note_id'], 'exist', 'skipOnError' => true, 'targetClass' => Note::className(), 'targetAttribute' => ['note_id' => 'id']],
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
            'content' => 'Content',
            'note_id' => 'Note ID',
            'order'=>'Order',
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
    public function getNote()
    {
        return $this->hasOne(Note::className(), ['id' => 'note_id']);
    }

    public function reorder($order){
        $note = $this->note;
        $this->order = $order;
        $this->save();
        $contentsAfter = $this->find()->where(['note_id'=>$note->id])->andWhere(['>=','order',$order])->andWhere(['<>','id',$this->id])->all();
        foreach ($contentsAfter as $contentAfter){
            $contentAfter->order += 1;
            $contentAfter->save();
        }
    }
}