<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Customer */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-view form_container">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'id',
            'username',
//            'password_hash',
//            'password_reset_token',
//            'auth_key',
            'firstname',
            'lastname',
            'dob',
            'gender',
            'email:email',
            'phone_number',
            'address',
            'image',
            'image_path',
            'language_id',
//            'zip_postal_code',
//            'is_active',
//            'status',
            'created_at',
            'updated_at',
            'total_purchase_orders',
            'total_purchase_products',
            'total_purchase_value',
        ],
    ]) ?>

</div>
