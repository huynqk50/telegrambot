<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TeleMessageSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tele-message-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'chat_id') ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'date') ?>

    <?= $form->field($model, 'forward_from') ?>

    <?php // echo $form->field($model, 'forward_from_chat') ?>

    <?php // echo $form->field($model, 'forward_from_message_id') ?>

    <?php // echo $form->field($model, 'forward_date') ?>

    <?php // echo $form->field($model, 'reply_to_chat') ?>

    <?php // echo $form->field($model, 'reply_to_message') ?>

    <?php // echo $form->field($model, 'media_group_id') ?>

    <?php // echo $form->field($model, 'text') ?>

    <?php // echo $form->field($model, 'entities') ?>

    <?php // echo $form->field($model, 'audio') ?>

    <?php // echo $form->field($model, 'document') ?>

    <?php // echo $form->field($model, 'photo') ?>

    <?php // echo $form->field($model, 'sticker') ?>

    <?php // echo $form->field($model, 'video') ?>

    <?php // echo $form->field($model, 'voice') ?>

    <?php // echo $form->field($model, 'video_note') ?>

    <?php // echo $form->field($model, 'contact') ?>

    <?php // echo $form->field($model, 'location') ?>

    <?php // echo $form->field($model, 'venue') ?>

    <?php // echo $form->field($model, 'caption') ?>

    <?php // echo $form->field($model, 'new_chat_members') ?>

    <?php // echo $form->field($model, 'left_chat_member') ?>

    <?php // echo $form->field($model, 'new_chat_title') ?>

    <?php // echo $form->field($model, 'new_chat_photo') ?>

    <?php // echo $form->field($model, 'delete_chat_photo') ?>

    <?php // echo $form->field($model, 'group_chat_created') ?>

    <?php // echo $form->field($model, 'supergroup_chat_created') ?>

    <?php // echo $form->field($model, 'channel_chat_created') ?>

    <?php // echo $form->field($model, 'migrate_to_chat_id') ?>

    <?php // echo $form->field($model, 'migrate_from_chat_id') ?>

    <?php // echo $form->field($model, 'pinned_message') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
