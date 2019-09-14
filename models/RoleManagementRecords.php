<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "role_management_records".
 *
 * @property int $id
 * @property int $user_id
 * @property string $item_name
 * @property string $action
 * @property int $last_modified_user_id
 * @property string $last_modified_date
 * @property int $created_user_id
 * @property string $created_date
 * @property int $active
 *
 * @property AuthItem $itemName
 * @property User $user
 */
class RoleManagementRecords extends \app\models\ActiveRecordVersion
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'role_management_records';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'item_name', 'action'], 'required'],
            [['user_id', 'last_modified_user_id', 'created_user_id', 'active'], 'integer'],
            [['last_modified_date', 'created_date'], 'safe'],
            [['item_name', 'action'], 'string', 'max' => 64],
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
            'item_name' => 'Item Name',
            'action' => 'Action',
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function findAuthItems(){
        $auth = Yii::$app->getAuthManager();
        $roles = $auth->getPermissions();
        $returnArray = [];
        foreach ($roles as $role){
            $returnArray[$role->name] = $role->description;
        }
        return $returnArray;
    }

    public function findUsers(){
        $users = User::find()->all();
        $returnArray = [];
        foreach ($users as $user){
            $returnArray[$user->id] = $user->user_name;
        }
        return $returnArray;
    }

    public function findActions(){
        return ['revoke'=>'Revoke','assign'=>'Assign'];
    }

}