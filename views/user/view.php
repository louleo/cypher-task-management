<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Edit', ['edit', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <table class="table table-striped table-bordered detail-view">
        <tbody>
        <?php
            foreach (['id','user_number','user_name','dob','active'] as $attribute){
                echo "<tr><th>".$model->getAttributeLabel($attribute)."</th><td>".$model->$attribute."</td></tr>";
            }
            foreach (['first_name','last_name','email','mobile','nick_name'] as $attribute){
                echo "<tr><th>".$model->contact->getAttributeLabel($attribute)."</th><td>".$model->contact->$attribute."</td></tr>";
             }
        ?>
        </tbody>
    </table>
</div>
