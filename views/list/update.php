<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BoardList */

$this->title = 'Update Board List: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Board Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="board-list-update">
    <div class="container">
        <div class="row">
                <div class="col-lg-10">
                    <h1><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="col-lg-2">
                    <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger float-right',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </div>
        </div>

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>


    </div>

</div>