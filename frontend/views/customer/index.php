<?php

use frontend\models\Customer;
use frontend\models\CustomerSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $searchModel CustomerSearch */
/* @var $dataProvider ActiveDataProvider */

?>
<div class="container" id="main">
    <div class="clr wrap news">
        <div class="clr navigation">
            <?= $this->render('//modules/breadcrumb') ?>
        </div>
        <article class="clr access-block">
            <div class="left">
                <h1 class="title">Thông tin cá nhân</h1>
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'username',
                        'firstname',
                        'lastname',
                        'email:email',
                        'phone_number',
                        [
                            'attribute' => 'gender',
                            'value' => $model->getGenderLabel(),
                        ],
                        [
                            'attribute' => 'dob',
                            'value' => date('d/m/Y', $model->dob),
                        ],
                        [
                            'attribute' => 'created_at',
                            'value' => date('d/m/Y H:i', $model->created_at),
                        ],
                        [
                            'attribute' => 'updated_at',
                            'value' => date('d/m/Y H:i', $model->updated_at),
                        ],
                    ],
                ]) ?>
            </div>
            <div class="right">
                <?= Html::a('Thay đổi thông tin', ['customer/update'], ['title' => 'Thay đổi thông tin', 'class' => 'btn-link']) ?>
                <?= Html::a('Thay đổi mật khẩu', ['customer/update-password'], ['title' => 'Thay đổi mật khẩu', 'class' => 'btn-link']) ?>
                <?= Html::a('Đăng xuất', ['site/logout'], ['title' => 'Đăng xuất', 'class' => 'block link']) ?>
            </div>
        </article>
    </div>
</div>