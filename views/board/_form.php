<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Board */
/* @var $form yii\widgets\ActiveForm */
?>

    <div class="board-form">

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'code')->textInput(['maxlength' => 20]) ?>

<?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

<?php
    if (isset($model->lists)){
        echo $form->field($model,'start_list_id')->dropDownList($model->obtainListsOptions(),['value'=>isset($model->start_list_id)? $model->start_list_id:null]);
        echo $form->field($model,'end_list_id')->dropDownList($model->obtainListsOptions(),['value'=> isset($model->end_list_id)? $model->end_list_id:null]);
    }
?>

<?= $form->field($model, 'github_repo')->textInput() ?>

<?= $form->field($model, 'active')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>

    </div>
