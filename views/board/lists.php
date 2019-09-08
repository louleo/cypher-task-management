<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Board';
?>
<div class="board-list-index">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

        <?php
            if (Yii::$app->user->can('admin')){
                ?>
                <p>
                    <?= Html::a('Create Board', ['create'], ['class' => 'btn btn-success']) ?>
                </p>
                <?php
            }
        ?>

    </div>


    <div class="container">
        <table class="table">
            <tr>
                <th>Board Id</th>
                <th>Name</th>
                <th>Description</th>
                <th>Status</th>
                <th>View</th>
                <th>Edit</th>
            </tr>
            <?php
            foreach ($models as $model){
                ?>
                <tr>
                    <td><?=$model->id?></td>
                    <td><?=$model->name?></td>
                    <td><?=$model->description?></td>
                    <td><?=$model->active?></td>
                    <td><a href="/board/view/<?=$model->id?>">View</a></td>
                    <td>
                    <?php
                        if ($model->isAdmin(Yii::$app->user->id)){
                            ?>
                            <a href="/board/update/<?=$model->id?>">Edit</a>
                    <?php
                        }
                    ?>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
    </div>


</div>