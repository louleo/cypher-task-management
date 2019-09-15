<?php

use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Role Management';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

    </div>


    <div class="container">
        <table class="table">
            <tr>
                <th>User Id</th>
                <th>User Name</th>
                <th>Status</th>
                <th>Roles</th>
            </tr>
            <?php
            foreach ($models as $model){
                ?>
                <tr>
                    <td><?=$model->id?></td>
                    <td><?=$model->username?></td>
                    <td><?=$model->active?></td>
                    <td><?=isset($model->userRoles)? implode(', ',$model->userRoles):'None';?></td>
                </tr>
                <?php
            }
            ?>
        </table>
    </div>

    <?=$this->render('_role_management_form', ['model'=>$model->roleManagementModel]);?>


</div>
