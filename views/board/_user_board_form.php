<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Board */
/* @var $form yii\widgets\ActiveForm */
?>

    <div class="container">

<?php $form = ActiveForm::begin(['action'=>'/board/add-user']); ?>

<?= $form->field($model, 'user_id')->dropDownList($model->getAllUsers());?>
<?= $form->field($model,'board_id')->hiddenInput()->label(false);?>
<?= $form->field($model,'is_admin')->checkbox();?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>

    </div>
