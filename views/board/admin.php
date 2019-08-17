<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Boards';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="board-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Board', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'id',
        'name',
        'description:ntext',
        'last_modified_user_id',
        'last_modified_date',
        //'created_user_id',
        //'created_date',
        //'active',

        ['class' => 'yii\grid\ActionColumn'],
    ],
]); ?>


    </div><?php
