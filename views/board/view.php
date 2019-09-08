<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Board */

$this->title = $board->name;
\yii\web\YiiAsset::register($this);
?>
<style>
div.board-board{
    overflow-x:auto;
    white-space: nowrap;
    min-height: 35em;
}
div.board-list-wrapper{
    width: 272px;
    margin: .5rem 4px;
    margin-left: 4px;
    height: 100%;
    box-sizing: border-box;
    display: inline-block;
    vertical-align: top;
    white-space: nowrap;
}
div.board-list{
    background-color: #dfe1e6;
    border-radius: 3px;
    box-sizing: border-box;
    display: flex;
    flex-direction: column;
    max-height: 100%;
    position: relative;
    white-space: normal;
}
div.board-list-header{
    flex: 0 0 auto;
    padding: 10px 8px;
    padding-right: 8px;
    position: relative;
    min-height: 20px;
    font-weight: 600;
}
div.board-list-cards{
    flex: 1 1 auto;
    margin-bottom: 0;
    overflow-y: auto;
    overflow-x: hidden;
    margin: 0 4px;
    padding: 0 4px;
    z-index: 1;
    min-height: 15px;
}
a.board-list-card {
    background-color: #fff;
    border-radius: 3px;
    box-shadow: 0 1px 0 rgba(9, 30, 66, .25);
    cursor: pointer;
    display: block;
    margin-bottom: 8px;
    max-width: 300px;
    min-height: 20px;
    position: relative;
    text-decoration: none;
    z-index: 0;
    color: #172b4d;
    padding: 1em;
}
a.board-add-card{
    border-radius: 0 0 3px 3px;
    color: #6b778c;
    display: block;
    flex: 0 0 auto;
    padding: 8px;
    position: relative;
    text-decoration: none;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    cursor: pointer;
}
a.board-list-header-edit{
    color: #6b778c;
    float: right;
}
</style>
<?php
    $boardAdmin = $board->isAdmin(Yii::$app->user->id);
?>
<div class="board-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <input type="hidden" id="global-board-code" value="<?=$board->code;?>">
    <div class="board-board">
        <?php
            foreach ($board->lists as $list){
                ?>
                <div class="board-list-wrapper">
                    <div class="board-list">
                        <div class="board-list-header">
                            <?= $list->name;?>
                            <?php
                                if ($boardAdmin){
                                    ?>
                                    <a class="board-list-header-edit" href="/list/update/<?=$list->id?>">Edit</a>
                                    <?php
                                }
                            ?>
                        </div>
                        <div class="board-list-cards js-board-list-cards-container" data-list-id="<?=$list->id?>" >
                            <?php
                            foreach ($list->cards as $card){
                                ?>
                                <a class="board-list-card js-board-list-card" data-card-id="<?=$card->id;?>" href="/card/view/<?=$card->id;?>" data-toggle="tooltip" data-placement="top" title="<?=$card->boardCode;?>">
                                        <div style="display: inline-block;padding:.2em;">
                                            <?=$card->title?>
                                        </div>
                                        <?php
                                        if (isset($card->assignee)){
                                            ?>
                                            <div class="float-right" style="padding: .2em;font-weight: bold;background: #818182;border-radius: 10px;">
                                                <?=$card->assignee->user_name;?>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                </a>
                                <?php
                            }
                            ?>
                        </div>
                        <a class="board-add-card js-board-list-create-card" data-list-id="<?=$list->id?>" data-href="/card/create/?list_id=<?=$list->id;?>">
                            <span>+</span>
                            <span>Add a new card</span>
                        </a>
                    </div>
                </div>
                <?php
            }
        ?>
        <div class="board-list-wrapper">
            <div class="board-list">
                <a class="board-add-card js-board-create-list" href="/list/create/?board_id=<?=$board->id;?>">
                    <span>+</span>
                    <span>Add a new list</span>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="board-card-view" tabindex="-1" role="dialog" aria-labelledby="cardModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cardModalLabel">Code</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="card-modal-content">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal-create -->
<div class="modal fade" id="board-create" tabindex="-1" role="dialog" aria-labelledby="create-modal-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="create-modal-label">Create</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="create-modal-content">
            </div>
        </div>
    </div>
</div>

<script>
    // $('.js-board-list-card').on('click',function () {
    //     let cardId = $(this).data('card-id');
    //     $.ajax({
    //         url:'/card/view/'+cardId,
    //         method:'GET',
    //         success:function (data) {
    //             $('#card-modal-content').html(data.html);
    //             $('#cardModalLabel').html(data.code);
    //             $('#board-card-view').modal({show:true});
    //         }
    //     });
    // });
    // $('.js-board-create-list').on('click',function(){
    //     $.ajax({
    //         url:'/list/create',
    //         method:'GET',
    //         success:function (data) {
    //             $('#create-modal-content').html(data.html);
    //             $('#create-modal-label').html(data.title);
    //             $('#board-create').modal({show:true});
    //         }
    //     });
    // });
    // $('.js-board-list-create-card').on('click',function () {
    //     let list_id = $(this).data('list-id');
    //     $.ajax({
    //         url:'/card/create-template',
    //         method:'GET',
    //         success:function (data) {
    //             $('#create-modal-content').html(data.html);
    //             $('#create-modal-label').html(data.title);
    //             $('#board-create').modal({show:true});
    //             $('#card-list_id').val(list_id);
    //             $('#card-code').val($('#global-board-code').val()+'-'+($('.js-board-list-card').length+1).toString());
    //         }
    //     });
    // });
    function cardMoveToList(card_id,list_id){
        $.ajax({
            url:'/card/move-to',
            data:{'list_id': list_id,'card_id': card_id},
            method:'GET',
            success:function (data) {

            }
        });
    }

    $('.js-board-list-create-card').on('click',function () {
       let board_code = $('#global-board-code').val();
       board_code += '-'+($('.js-board-list-card').length+1).toString();
       window.location.href = $(this).data('href')+'&code='+board_code;
    });
    let dragulaArray = [];
    $('.js-board-list-cards-container').each(function () {
       dragulaArray.push($(this)[0]);
    });

    dragula(dragulaArray).on('drop',function (el,target,source,sibling) {
        cardMoveToList($(el).data('card-id'),$(target).data('list-id'));
    });
</script>