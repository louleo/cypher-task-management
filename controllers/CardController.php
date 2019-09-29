<?php

namespace app\controllers;

use app\models\Board;
use app\models\BoardList;
use app\models\CardUserAssign;
use Yii;
use app\models\Card;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\HttpException;
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
                            'delete',
                        ],
                        'roles' => ['admin'],
                    ],
                    [
                        'allow' => true,
                        'actions'=>[
                            'create',
                            'view',
                            'update',
                            'create-template',
                            'move-to',
                            'user-assign',
                        ],
                        'roles'=>['@']
                    ],
                    [
                        'allow'=>true,
                        'actions'=>[
                            'update-github'
                        ],
                        'roles'=>['@','?']
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

        $model->code = $model->initCode();

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
        $this->findModel($id)->deactivate();
        return $this->redirect(['/board/index']);
    }

    public function actionMoveTo(){

        $successful = false;
        $request = Yii::$app->getRequest();
        $card_id = $request->get('card_id');
        $list_id = $request->get('list_id');
        if (isset($card_id) && isset($list_id)){
            if ($this->findModel($card_id)->moveTo($list_id)){
                $successful = true;
            }
        }
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return ['flag'=>$successful];
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

    public function actionUserAssign(){
        $successful = false;
        $request = Yii::$app->getRequest();
        $card_id = $request->get('card_id');
        $user_id = $request->get('user_id');

        $cardUserAssigns = CardUserAssign::findAll(['card_id'=>$card_id]);

        if (isset($cardUserAssigns)){
            foreach ($cardUserAssigns as $cardUserAssign){
                $cardUserAssign->delete();
            }
        }

        if (isset($card_id) && isset($user_id) && $user_id){
            if ($this->findModel($card_id)->assignTo($user_id)){
                $successful = true;
            }
        }

        if ($user_id == 0){
            $successful = true;
        }

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return ['flag'=>$successful];
    }

    public function beforeAction($action)
    {
        if (in_array($action->id, ['github'])) {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    public function actionUpdateGithub(){
        $request = Yii::$app->request;
        $headers = $request->headers;
        $sign = $headers->get('X-Hub-Signature');
        $secret = 'sha1='.sha1("louleo1103cypher");
        if ($sign == $secret){
            if ($_POST && $_POST['payload']){
                $payload = Json::decode($_POST['payload'], true);
                if (isset($payload['action']) && $payload['action'] == 'opened'){
                    $pr_title = $payload['pull_request']['title'];
                    $pr_array = explode(' ',$pr_title);
                    $pr_repo = $payload['html_url'];
                    $board = Board::find(['github_repo'=>$pr_repo])->one();
                    if (isset($board)){
                        $board_code = strtolower($board->code);
                        $card_number = 0;
                        foreach ($pr_array as $pr_str){
                            $pos = strpos(strtolower($pr_str),$board_code);
                            if ($pos !== false){
                                $card_number = preg_replace('/[^0-9]/','',substr($pr_str,$pos));
                                break;
                            }
                        }
                        $command = Yii::$app->db->createCommand();
                        $command->sql = "select card.id from board left join list on board.id = list.board_id left join card on list.id = card.list_id where board.id = ".$board->id."and card.code = ".$card_number;
                        $card_id = $command->query();
                        if (isset($card_id) && !empty($card_id)){
                            $card = $this->findModel($card_id[0]);
                            $card->github_pr_link = $payload['pull_request']['url'];
                            if ($card->save()){
                                echo "Successfully updated!";
                            }
                        }
                    }
                }
            }
        }

        throw new HttpException(404,'The page you request is not found.');


    }
}