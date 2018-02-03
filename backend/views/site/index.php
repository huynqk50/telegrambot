<?php

use backend\models\User;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;
use yii\helpers\Url;

if (count($statistics) > 0) {
    foreach ($statistics as $username => $item) {
        $user = $item['user'];
        $actions = $item['actions'];
?>
<div class="row" style="margin: 0.5em auto">  
    <div class="col-md-12">
        <?= Html::a($user->username, Url::to(['user/update', 'id' => $user->id], true)) ?>
    </div>
    <div class="col-md-12">
        <?= $actions['create']['t_action'] ?> <span class="text-success"><?= count($actions['create']['objects']) ?></span>
        &middot; <?= $actions['update']['t_action'] ?> <span class="text-primary"><?= count($actions['update']['objects']) ?></span>
        &middot; <?= $actions['delete']['t_action'] ?> <span class="text-danger"><?= count($actions['delete']['objects']) ?></span>
    </div>
    <?php
    foreach ($actions['create']['objects'] as $object) {
    ?>
    <div class="col-md-12">
        <time class="text-detail"><?= $object['time'] ?></time>
        <?= Html::a($actions['create']['t_action'], Url::to([Inflector::camel2id($object['name']) . '/create'], true), ['class' => 'text-black']) ?>
        <?php
        if ($object['model'] !== null) {
            echo Html::a($object['t_name'], Url::to([Inflector::camel2id($object['name']) . '/update', 'id' => $object['model']->id], true), ['class' => 'text-success']);
            echo ' ' . Html::a(
                (strlen($object['model']->getLink()) > 60 ? '...' : '') . substr($object['model']->getLink(), -60),
                $object['model']->getLink(),
                [
                    'target' => '_blank',
                    'class' => 'text-gray',
                    'onmouseover' => '$(this).toggleClass("text-orange")',
                    'onmouseout' => '$(this).removeClass("text-orange")'
                ]
            );
        } else {
            echo "<span class=\"text-success\">{$object['t_name']}</span>";
            if ($object['deleted_by'] !== null) {
                echo " <span class=\"text-gray\">(Đã xóa bởi {$object['deleted_by']})</span>";
            }
        }
        ?>
    </div>
    <?php
    }
    ?>
</div>
<?php
    }
}
?>