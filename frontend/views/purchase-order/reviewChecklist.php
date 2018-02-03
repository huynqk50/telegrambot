<?php

use common\models\Currency;
use frontend\models\Product;
use frontend\models\SiteParam;

?>
<?php
if ($review['customer_info'] != [] && $review['list_items'] != []) {
    $customer = $review['customer_info'];
    $list_items = $review['list_items'];
    $product_name_list = '';
    foreach ($review['list_items'] as $item) {
        $product_name_list .= "<span class=\"text-pink\">{$item['product_name']} - {$item['product_customization_name']} ({$item['quantity']})</span>, ";
    }
    $product_name_list = trim(trim($product_name_list), ',');
    $hotline = SiteParam::findOneByName(SiteParam::PARAM_PHONE_NUMBER);
?>
<div class="clr order-checklist">
    <section>
        <div class="title">Giỏ hàng</div>
        <div class="content">
            <div class="sub-title">Đặt hàng thành công <span class="icon success-icon"></span></div>
            <article>
                <p>
                    Quý khách vừa đặt thành công sản phẩm <?= $product_name_list ?> Thông tin đặt hàng của quý khách sẽ được chúng tôi cập nhật và gửi cho quý khách trong thời gian sớm nhất. Cám ơn quý khách đã mua hàng tại website của chúng tôi.
                </p>
                <p>
                    Mọi thông tin về đơn hàng sẽ được gửi tới email của quý khách, vui lòng kiểm tra email để biết thêm chi tiết.
                </p>
                <p>
                    Mọi thắc mắc vui lòng liên hệ: <a class="text-pink"><b><?= $hotline ? $hotline->value : '' ?></b></a>
                </p>
            </article>
            <article class="table-wrap">
                <table>
                    <caption>Chi tiết đơn hàng</caption>
                    <thead>
                    <tr>
                        <td colspan="3">
                            <h4><?= $customer['customer_name'] ?></h4>
                            <div>SĐT: <?= $customer['customer_phone_number'] ?></div>
                            <div>Địa chỉ: <?= $customer['customer_address'] ?></div>
                            <div>Thư xác nhận đã được gửi tới email: <b><?= $customer['customer_email'] ?></b></div>
                        </td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $total_amount = 0;
                    foreach ($list_items as $item) {
                        $total_amount += $item['quantity'] * $item['unit_price'];
                        ?>
                        <tr>
                            <td class="image">
                                <?= $item['img_tag'] ?>
                            </td>
                            <td class="desc">
                                <?= $item['a_tag'] ?> (<?= $item['product_customization_name'] ?>)
                                Số lượng - <?= $item['quantity'] ?>
                            </td>
                            <td class="amount">
                                Tạm tính: <span class="long-vnd"><?= $item['quantity'] * $item['unit_price'] ?></span>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="2"></td>
                        <td>
                            <div><strong>Thành tiền: <span class="text-pink long-vnd"><?= $total_amount ?></span></strong></div>
                            <sub>(Đã bao gồm thuế)</sub>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </article>
        </div>
    </section>
</div>
<?php
}