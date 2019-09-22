<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Notes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="note-index h-100">

    <div class="container-fluid">
        <div class="row align-items-center" style="position: relative;">
            <h1 class="display-3"><?= Html::encode($this->title) ?></h1>
            <?= Html::a('Create Note', ['create'], ['class' => 'btn btn-success', 'style'=>'position:absolute;right:0;']) ?>
        </div>
    </div>


    <div class="container-fluid">
        <?php
            foreach ($models as $model){
                ?>
            <div class="row py-3">
                <h2 class="d-block w-100"><a href="/note/view/<?=$model->id?>" class="display-4 d-inline-block"><?=$model->title?></a><span class="small d-inline-block pl-3">By <?=$model->createdUser->fullName?></span></h2>
                <div class="d-block w-100 py-2">
                    <i class="fas fa-calendar-alt"></i> <strong><?=$model->lastModifiedDate?></strong>
                </div>
                <div class="d-block w-100 py-2">
                    <?=$model->description?>
                </div>
            </div>
        <?php
            }
        ?>
    </div>
</div>