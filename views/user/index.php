<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    </div>


    <div class="container">
        <table class="table">
            <tr>
                <th>User Id</th>
                <th>User Name</th>
                <th>Status</th>
                <th>View</th>
                <th>Edit</th>
            </tr>
            <?php
                foreach ($models as $model){
                    ?>
                <tr>
                    <td><?=$model->id?></td>
                    <td><?=$model->username?></td>
                    <td><?=$model->active?></td>
                    <td><a href="/user/view/<?=$model->id?>">View</a></td>
                    <td><a href="/user/update/<?=$model->id?>">Edit</a></td>
                </tr>
                    <?php
                }
            ?>
        </table>
    </div>


</div>
