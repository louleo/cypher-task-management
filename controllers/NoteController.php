<?php

namespace app\controllers;

use Symfony\Component\Console\Tests\Output\NullOutputTest;
use Yii;
use app\models\Note;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NoteController implements the CRUD actions for Note model.
 */
class NoteController extends Controller
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
                        'actions'=>[
                            'create',
                            'update',
                            'delete',
                            'view',
                            'index',
                            'edit',
                        ],
                        'roles'=>['@']
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Note models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->can('admin')){
            $notes = Note::find()->orderBy(['last_modified_date'=>SORT_DESC])->all();
        }else{
            $notes = Note::find()->where(['is_public'=>1])->orWhere(['created_user_id'=>Yii::$app->user->id])->andWhere(['active'=>1])->orderBy(['last_modified_date'=>SORT_DESC])->all();
        }

        return $this->render('index', [
            'models' => $notes,
        ]);
    }

    /**
     * Displays a single Note model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if (!$model->is_public){
            if (!$this->canEdit($model->created_user_id,true)){
                throw new HttpException(404,'This is not the web page you are looking for.');
            }
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Note model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Note();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Note model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $this->canEdit($model->created_user_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionEdit($id)
    {
        $model = $this->findModel($id);

        $this->canEdit($model->created_user_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['edit', 'id' => $model->id]);
        }

        return $this->render('edit', [
            'model' => $model,
        ]);
    }


    /**
     * Deletes an existing Note model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($this->canEdit($model->created_user_id,true)){
            $this->findModel($id)->deactivate();
        }else{
            throw new HttpException(403,'You have no permission to perform this action.');
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Note model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Note the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Note::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function canEdit($created_user_id,$return = false){
        if (($created_user_id == Yii::$app->user->id) || (Yii::$app->user->can('admin'))){
            return true;
        }

        if (!$return){
            throw new HttpException(403,'You have no permission to perform this action.');
        }

        return false;

    }

}