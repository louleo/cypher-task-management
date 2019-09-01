<?php

namespace app\controllers;

use Yii;
use app\models\BoardList;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BoardListController implements the CRUD actions for BoardList model.
 */
class ListController extends Controller
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
                        ],
                        'roles'=>['@']
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all BoardList models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => BoardList::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BoardList model.
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
     * Creates a new BoardList model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BoardList();

        $board_id = Yii::$app->request->get('board_id');

        if (isset($board_id)){
            $model->board_id = $board_id;
        }

        if (isset($model->board_id)){
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
               return $this->redirect('/board/view/'.$model->board_id);
            }
            return $this->render('create',['model'=>$model]);
        }else{
            $this->redirect('/board/index');
        }

//
//        $output = $this->renderPartial('create', [
//            'model' => $model,
//        ]);
//        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
//        return ['html'=>$output,'title'=>'Create New List'];


    }

    /**
     * Updates an existing BoardList model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->redirect('/board/view/'.$model->board_id);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing BoardList model.
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
     * Finds the BoardList model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BoardList the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BoardList::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}