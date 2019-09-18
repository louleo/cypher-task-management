<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $user_number
 * @property string $user_name
 * @property string $dob
 * @property string $password
 * @property int $last_modified_user_id
 * @property string $last_modified_date
 * @property int $created_user_id
 * @property string $created_date
 * @property int $active
 *
 * @property User $createdUser
 * @property User[] $users
 * @property User $lastModifiedUser
 * @property User[] $users0
 */
class User extends ActiveRecordVersion implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_number', 'dob'], 'required'],
            [['dob', 'last_modified_date', 'created_date'], 'safe'],
            [['last_modified_user_id', 'created_user_id', 'active'], 'integer'],
            [['user_number', 'user_name', 'password'], 'string', 'max' => 255],
            [['created_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_user_id' => 'id']],
            [['last_modified_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['last_modified_user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_number' => 'User Number',
            'user_name' => 'User Name',
            'dob' => 'Dob',
            'password' => 'Password',
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
    public function getCreatedUser()
    {
        return $this->hasOne(User::className(), ['id' => 'created_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastModifiedUser()
    {
        return $this->hasOne(User::className(), ['id' => 'last_modified_user_id']);
    }

    public static function findByUsername($userName){
        return User::find()->where(['user_name' => $userName])->one();
    }

    public function validatePassword($password){
        return password_verify($password,$this->password);
    }

    /**
     * Finds an identity by the given ID.
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        // TODO: Implement findIdentity() method.
        return User::find()->where(['id'=>$id])->one();
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface|null the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
        return null;
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        // TODO: Implement getId() method.
        return $this->id;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled. The returned key will be stored on the
     * client side as a cookie and will be used to authenticate user even if PHP session has been expired.
     *
     * Make sure to invalidate earlier issued authKeys when you implement force user logout, password change and
     * other scenarios, that require forceful access revocation for old sessions.
     *
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
        return null;
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
        return true;
    }

    public function getUserName(){
        return $this->getNickName();
    }

    public function getContact(){
        return $this->hasOne(Contact::className(), ['user_id' => 'id']);
    }

    public function getNickName(){
        $model = $this->contact;
        if (isset($model)){
            return $model->nick_name;
        }
        return $this->user_name;
    }

    public function getFirstName(){
        $model = $this->contact;
        if (isset($model)){
            return $model->first_name;
        }
        return $this->user_name;
    }

    public function getLastName(){
        $model = $this->contact;
        if (isset($model)){
            return $model->last_name;
        }
        return $this->user_name;
    }

    public function getEmail(){
        $model = $this->contact;
        if (isset($model)){
            return $model->email;
        }
        return null;
    }

    public function getMobile(){
        $model = $this->contact;
        if (isset($model)){
            return $model->mobile;
        }
        return null;
    }

    public function getUserRoles(){
        $auth = Yii::$app->authManager;
        $returnArray = [];
        $userId = $this->id;
        $assignments = $auth->getPermissionsByUser($userId);
        if (isset($assignments)){
            foreach ($assignments as $assignment){
                $returnArray[] = $assignment->description;
            }
            return $returnArray;
        }else{
            return null;
        }
    }

    public function getRoleManagementModel(){
        return new RoleManagementRecords();
    }

    public function savePassword($password){
        $this->password = password_hash($password,1);
        $this->save();
    }

    public function beforesave($insert)
    {
        if (isset($this->dob) && preg_match("/^(0[1-9]|1[0-2])\/(0[1-9]|[1-2][0-9]|3[0-1])\/[0-9]{4}$/", $this->dob)) {
            $this->dateFormat('dob');
        } else {
            $this->dob = null;
        }
        return parent::beforesave($insert);
    }

}
