<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BoardList */
/* @var $form yii\widgets\ActiveForm */
?>
<?php

$orderOption = [];

$optionNubmber = $model->listNumber;

for ($i = 1; $i<= $optionNubmber; $i++){
    $orderOption[$i] = $i;
}

?>

<div class="board-list-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'board_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order')->dropDownList($orderOption) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>