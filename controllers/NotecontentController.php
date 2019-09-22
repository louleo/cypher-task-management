<?php

namespace app\controllers;

use Yii;
use app\models\NoteContent;
use app\models\Note;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NoteContentController implements the CRUD actions for NoteContent model.
 */
class NotecontentController extends Controller
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
                            'index',
                            'view',
                            'delete',
                        ],
                        'roles'=>['admin']
                    ],
                    [
                        'allow' => true,
                        'actions'=>[
                            'create',
                            'update',
                            'reorder',
                        ],
                        'roles'=>['@']
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all NoteContent models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => NoteContent::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single NoteContent model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new NoteContent model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new NoteContent();

        $noteModel = $this->findNoteModel($id);

        $this->canEdit($noteModel->created_user_id);

        $model->note_id = $id;

        $model->order = $noteModel->noteContentOrder();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/note/edit', 'id' => $noteModel->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing NoteContent model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $noteModel = $model->note;

        if (isset($noteModel)){
            $this->canEdit($noteModel->created_user_id);
        }else{
            throw new HttpException('403','You are not allowed to perform this action.');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/note/edit', 'id' => $noteModel->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing NoteContent model.
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

    public function actionReorder(){
        $id = Yii::$app->request->getQueryParam('c_id');
        $order = Yii::$app->request->getQueryParam('c_order');

        if (isset($id) && isset($order) && is_numeric($order)){
            $content = $this->findModel($id);
            $note = $content->note;
            $this->canEdit($note->created_user_id);
            $content->reorder($order);
            echo Json::encode(['data'=>'true']);
        }else{
            throw new BadRequestHttpException('The request is invalid. Please try again.');
        }

    }

    /**
     * Finds the NoteContent model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return NoteContent the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = NoteContent::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findNoteModel($id){
        if (($model = Note::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function canEdit($created_user_id,$return = false){
        if (!$created_user_id == Yii::$app->user->id && !Yii::$app->user->can('admin')){
            if ($return){
                return false;
            }else{
                throw new HttpException(403,'You have no permission to perform this action.');
            }
        }
        return true;
    }
}
