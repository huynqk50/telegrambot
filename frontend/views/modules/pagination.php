<?php

use common\utils\Pagination;

$pageOpt = Pagination::data(
    ['current' => $data['current'], 'total' => $data['total']],
    ['left' => 2, 'right' => 3]
);

?>
<div class="clearfix paging">
<ul class="pagination fr">
    <?php
    if (count($pageOpt['arr']) > 1) {
        if ($pageOpt['btn']['first']) {
            ?>
            <li><a title="Trở về trang đầu" href="<?= $this->context->link_canonical ?>">Đầu tiên</a></li>
            <?php
        }
        foreach ($pageOpt['arr'] as $p) {
            ?>
            <li <?= $p == $data['current'] ? 'class="active"' : '' ?>><a title="Trang <?= $p ?>" href="<?= $this->context->link_canonical ?><?= $p > 1 ? '?page=' . $p : '' ?>"><?= $p ?></a></li>
            <?php
        }
        if ($pageOpt['btn']['last']) {
            ?>
            <li><a title="Đi đến trang cuối" href="<?= $this->context->link_canonical . '?page=' . $data['total'] ?>">Cuối cùng</a></li>
            <?php
        }
    }
    ?>
</ul>
</div>