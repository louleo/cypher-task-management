<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Card */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Cards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="card-view">

    <div class="container card-view-container" >
        <h1><?= Html::encode($this->title) ?></h1>
        <div class="row">
            <div class="col-lg-9">
                <div class="container-fluid">
                    <div class="row">
                        <h3>Description</h3>
                        <div class="container-fluid" style="min-height: 200px;">
                            <?=$model->description;?>
                        </div>
                    </div>
                    <div class="row">
                        <h3>Comments</h3>
                        <div class="container-fluid">

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="container-fluid">
                    <div class="row">
                        <h4>Assign to</h4>
                    </div>
                    <div class="row">
                        <h4>Start Date</h4>
                    </div>
                    <div class="row">
                        <h4>Due Date</h4>
                    </div>
                    <div class="row">
                        <h4>End Date</h4>
                    </div>
                    <div class="row">
                        <h4>Creator</h4>
                        <div class="container-fluid">
                            <?=$model->creator->username;?>
                        </div>
                    </div>
                    <div class="row">
                        <h4>Move To</h4>
                        <div class="container-fluid">

                        </div>
                    </div>
                    <div class="row">
                            <?= Html::a('Edit', ['update', 'id' => $model->id],
                                [
//                                        'class' => 'btn btn-primary'
                                ]
                            ) ?>
                    </div>
                    <div class="row">
                        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
//                                'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </div>
                    <div class="row">
                        <a href="/board/view/<?=$model->list->board->id?>">Back To Board</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>