<?php

namespace app\controllers;

use app\models\BoardList;
use Yii;
use app\models\Card;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CardController implements the CRUD actions for Card model.
 */
class CardController extends Controller
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
                            'index',
                            'create',
                            'delete',
                        ],
                        'roles' => ['admin'],
                    ],
                    [
                        'allow' => true,
                        'actions'=>[
                            'view',
                            'update',
                            'create-template',
                        ],
                        'roles'=>['@']
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Card models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Card::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Card model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
//         $output = $this->renderPartial('view', [
//            'model' => $model,
//        ]);
//         Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
//         return ['html'=>$output,'code'=>$model->code];
        return $this->render('view',['model'=>$model]);
    }

    /**
     * Creates a new Card model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Card();
//        $successful = false;
//        $data = null;
//        if ($model->load(Yii::$app->request->post())) {
//            try{
//                $successful = $model->validate();
//            } catch (\Exception $e){
//                $data = $e->getMessage();
//            }
//
//            if ($successful){
//                $model->save();
//            }
//        }
//
//
//        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
//
//        return ['flag'=>$successful,'data'=>$data];
        $list_id = Yii::$app->request->get('list_id');

        if (isset($list_id)){
            $model->list_id = $list_id;
        }

        $code = Yii::$app->request->get('code');

        if (isset($code)){
            $model->code = $code;
        }

        if (isset($model->code) && isset($model->list_id)){
            if ($model->load(Yii::$app->request->post()) && $model->save()){
                return $this->redirect(['board/view', 'id' => $model->list->board_id]);
            }
            return $this->render('create',['model'=>$model]);
        }else{
            $this->redirect('/board/index');
        }
    }


    public function actionCreateTemplate(){
        $model = new Card();

        $output = $this->renderPartial('create', [
            'model' => $model,
        ]);

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return ['html'=>$output,'title'=>'Create New Card'];
    }

    /**
     * Updates an existing Card model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Card model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Card model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Card the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Card::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}