<?php

namespace app\controllers;

use app\models\Contact;
use app\models\RoleManagementRecords;
use phpDocumentor\Reflection\DocBlock\Tags\Author;
use Yii;
use app\models\User;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\AccessRule;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'create',
                            'delete',
                            'update',
                            'role-management',
                            'role-change',
                        ],
                        'roles' => ['admin'],
                    ],
                    [
                        'allow' => true,
                        'actions'=>[
                            'index',
                            'view',
                            'edit'
                        ],
                        'roles'=>['@']
                    ],
                ],
            ]
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->can('admin')){
            $users = User::find()->all();

            return $this->render('index', [
                'models' => $users,
            ]);
        }else{
            return $this->redirect(['edit','id'=>Yii::$app->user->id]);
        }

    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (Yii::$app->user->can('admin') || Yii::$app->user->id == $id){
            if (!isset($model->contact)){
                return $this->redirect(['edit','id'=>$id]);
            }

            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }else{
            throw new HttpException(403,'You are not allowed to perform this action.');
        }

    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        $contact = new Contact();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $contact->attributes = $_POST['Contact'];
            $contact->user_id = $model->id;
            $contact->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'contact'=>$contact,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->id == $id || Yii::$app->user->can('admin')){
            $model = $this->findModel($id);
            if (!isset($model->contact)){
                $contact = new Contact();
                $contact->user_id = $model->id;
            }else{
                $contact = $model->contact;
            }
            if (isset($_POST['User']) && !empty($_POST['User'])){
                $model->user_name = $_POST['User']['user_name'];
                $model->user_number = $_POST['User']['user_number'];
                if (!empty($_POST['User']['password'])){
                    $model->password = password_hash($_POST['User']['password'],1);
                }
                $model->dob = $_POST['User']['dob'];
                $model->active = $_POST['User']['active'];
                if ($model->save()){
                    $contact->load(Yii::$app->request->post());
                    $contact->save();
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
            $model->password = '';
            return $this->render('update', [
                'model' => $model,
                'contact'=>$contact,
            ]);
        }else{
            throw new HttpException(403,'You are not allowed to perform this action.');
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->deactivate();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function roleAssign($role,$userId,$action = 'assign'){
        $auth = Yii::$app->getAuthManager();
        $role = $auth->getPermission($role);
        $auth->$action($role,$userId);
    }

    public function actionRoleManagement(){
        $users = User::find()->all();

        return $this->render('role-management', [
            'models' => $users,
        ]);
    }

    //todo: need to change the function to a better, less resource-consumed way
    public function actionRoleChange(){
        $model = new RoleManagementRecords();
        $model->load(Yii::$app->request->post());
        if (!($model->user_id == 1 && $model->action == 'revoke')){
            if ($model->save()){
                $this->roleAssign($model->item_name,$model->user_id,$model->action);
            }
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionEdit($id){
        $model = $this->findModel($id);
        $contactModel = $model->contact;
        if (!isset($contactModel)){
            $contactModel = new Contact();
        }

        $contactModel->user_id = $model->id;

        if ($contactModel->load(Yii::$app->request->post()) && $contactModel->save()) {
            if (isset($_POST['User']['password'])){
                $contactModel->user->savePassword($_POST['User']['password']);
            }
            return $this->redirect(['/contact/view', 'id' => $contactModel->id]);
        }

        return $this->render('edit', [
            'model' => $contactModel,
        ]);

    }
}
