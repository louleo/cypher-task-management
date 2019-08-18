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

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>