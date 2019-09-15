<?php

namespace app\controllers;

use app\models\BoardList;
use app\models\BoardUserAssign;
use Yii;
use app\models\Board;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BoardController implements the CRUD actions for Board model.
 */
class BoardController extends Controller
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
                            'delete-user',
                            'add-user',
                        ],
                        'roles' => ['admin'],
                    ],
                    [
                        'allow' => true,
                        'actions'=>[
                            'index',
                            'view',
                            'lists',
                        ],
                        'roles'=>['@']
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Board models.
     * @return mixed
     */
    public function actionIndex()
    {
        $defaultBoard = Board::getDefaultBoard(Yii::$app->user->id);
        if ($defaultBoard){
            return $this->render('view', [
                'board' => $defaultBoard,
            ]);
        }else{
            $this->redirect('/board/create');
        }
    }

    /**
     * Displays a single Board model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $curBoard = $this->findModel($id);

        if (isset($curBoard)){
            if ($curBoard->isUser(Yii::$app->user->id)){
                return $this->render('view', [
                    'board' => $curBoard,
                ]);
            }
        }

        throw new HttpException(403,'You do not have permission to create a board.');

    }

    /**
     * Creates a new Board model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->can('admin') || Yii::$app->user->can('createBoard')){
            $model = new Board();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                $boardUserAssign = new BoardUserAssign();
                $boardUserAssign->board_id = $model->id;
                $boardUserAssign->user_id = $model->created_user_id;
                $boardUserAssign->is_admin = 1;
                $boardUserAssign->save();

                $allAdminUsers = Yii::$app->authManager->getUserIdsByRole('admin');

                foreach ($allAdminUsers as $adminUser){
                    $existingBoardUserAssign = BoardUserAssign::findOne(['board_id'=>$model->id,'user_id'=>$adminUser]);
                    if (isset($existingBoardUserAssign)){
                        $existingBoardUserAssign->is_admin = 1;
                        $existingBoardUserAssign->save();
                    }else{
                        $boardUserAssign = new BoardUserAssign();
                        $boardUserAssign->board_id = $model->id;
                        $boardUserAssign->user_id = $adminUser;
                        $boardUserAssign->is_admin = 1;
                        $boardUserAssign->save();
                    }
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('create', [
                'model' => $model,
            ]);
        }

        throw new HttpException(403,'You do not have permission to create a board.');


    }

    /**
     * Updates an existing Board model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->user->can('admin') || Yii::$app->user->id == $model->created_user_id || $model->isAdmin(Yii::$app->user->id)){
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        }

        throw new HttpException(403, 'You do not have the permission to modify any information of this board.');

    }

    /**
     * Deletes an existing Board model.
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
     * Finds the Board model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Board the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Board::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionLists(){
        $boards = Board::find()->leftJoin('board_user_assign','board_user_assign.board_id = board.id')->where(['board_user_assign.user_id'=>Yii::$app->user->id])->all();

        return $this->render('lists', [
            'models' => $boards,
        ]);
    }

    public function actionDeleteUser($id){
        $boardUserAssign = BoardUserAssign::findOne(['id'=>$id]);
        if (isset($boardUserAssign)){
            $board_id = $boardUserAssign->board_id;
            $boardUserAssign->delete();
        }
        if (isset($board_id)){
            return $this->redirect(['update','id'=>$board_id]);
        }else{
            return $this->redirect(['index']);
        }
    }

    public function actionAddUser(){
        if (Yii::$app->user->can('admin')){
            $model = new BoardUserAssign();

            $model->load(Yii::$app->request->post());

            $existingModel = BoardUserAssign::findOne(['board_id'=>$model->board_id,'user_id'=>$model->user_id]);

            if (!isset($existingModel)){
                $model->save();
            }else{
                $existingModel->is_admin = $model->is_admin;
                $existingModel->save();
            }

            return $this->redirect(Yii::$app->request->referrer);
        }

        throw new HttpException(403, 'You do not have the permission to modify any information of this board.');
    }
}