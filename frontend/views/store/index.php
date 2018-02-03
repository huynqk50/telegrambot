<?php

use yii\helpers\Url;

?>
<div class="container" id="main">
    <div class="clr wrap shop">
        <div class="divider"></div>
        <div class="clr">
            <div class="right img-wrap decor">
                <img src="<?= Url::home(true) ?>images/demo/cua-hang-1.jpg">
            </div>
            <div class="left title">Hệ thống showroom Veneto trên toàn quốc</div>
            <div class="left list">
                <ul>
                    <?php
                    $i = 0;
                    foreach ($stores as $item) {
                        if (++ $i % 6 == 0) {
                            echo '<li></li>';
                        }
                        echo "<li>Store $i: $item->name</li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
        <div class="img-wrap decor">
            <div class="clr">
                <img class="left" src="<?= Url::home(true) ?>images/demo/cua-hang-3.jpg">
                <img class="right" src="<?= Url::home(true) ?>images/demo/cua-hang-2.jpg">
            </div>
        </div>
    </div>
</div>