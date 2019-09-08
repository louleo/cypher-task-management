<?php


use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Board */

$this->title = 'Update Board: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Boards', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="board-update">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

    <div class="container">
        <h2>Board Management</h2>
        <table class="table">
            <tr>
                <th>No.</th>
                <th>User</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
            <?php
                $no = 1;
                foreach ($model->boardUserAssigns as $boardUserAssign){
                    ?>
                    <tr>
                        <td>
                            <?=$no?>
                        </td>
                        <td>
                            <?=$boardUserAssign->user->user_name?>
                        </td>
                        <td>
                            <?=($boardUserAssign->is_admin)?'Admin User':'Normal User'?>
                        </td>
                        <td>
                            <?php
                                if (!$boardUserAssign->is_admin){
                                    ?>
                                    <a href="/board/delete-user/?id=<?=$boardUserAssign->id?>">Delete</a>
                            <?php
                                }
                            ?>
                        </td>
                    </tr>
            <?php
                    $no++;
                }
            ?>
        </table>
    </div>

    <?php
        if (Yii::$app->user->can('admin')){
            $boardUserAssign = $model->createNewBoardUserAssign();
            ?>
    <div class="container">
        <h2>Add User To Board</h2>
        <div class="row">
            <?= $this->render('_user_board_form', [
                'model' => $boardUserAssign,
            ]) ?>
        </div>
    </div>
    <?php
        }
    ?>
</div>