<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RoleManagementRecords */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="role-management-records-form container">

    <?php $form = ActiveForm::begin(['action'=>'/user/role-change']); ?>

    <?= $form->field($model, 'action')->dropDownList($model->findActions()) ?>

    <?= $form->field($model, 'user_id')->dropDownList($model->findUsers()) ?>

    <?= $form->field($model, 'item_name')->dropDownList($model->findAuthItems()) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>