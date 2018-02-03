<?php

use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>
<div class="clr cart">
    <section>
        <h1 class="title">Giỏ hàng</h1>
        <div class="content">
            <h2 class="sub-title">1. Giỏ hàng của tôi</h2>
            <article class="table-wrap">
                <table id="cart-checkout">
                    <thead>
                        <tr>
                            <th>&nbsp;</th>
                            <th>Tên sản phẩm</th>
                            <th>Đơn giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                            <th>Xóa</th>
                        </tr>
                    </thead>
                    <tbody id="cart-data">
                    </tbody>
                    <tfoot>
                    <tr>
                        <td>
                            <button class="text-blue" onclick="location.href='<?= Url::home(true) ?>'">
                                <i class="icon back-icon"></i>
                                Tiếp tục mua hàng
                            </button>
                        </td>
                        <td>&nbsp;</td>
                        <td colspan="2">
                            <strong>Tổng cộng:</strong>
                            <br>
                            <sub>(Đã bao gồm thuế)</sub>
                        </td>
                        <td class="total-amount long-vnd" id="total-amount">
                        </td>
                        <td>&nbsp;</td>
                    </tr>
                    </tfoot>
                </table>
            </article>
            <h2 class="sub-title">2. Thông tin đặt hàng</h2>
            <?php $form = ActiveForm::begin(['options' => ['class' => 'primary']]); ?>
                <?= $form->field($order, 'customer_name', ['template' => '{input}{label}{error}{hint}'])->textInput(['maxLength' => true]) ?>
                <?= $form->field($order, 'customer_phone_number', ['template' => '{input}{label}{error}{hint}'])->textInput(['maxLength' => true]) ?>
                <?= $form->field($order, 'customer_email', ['template' => '{input}{label}{error}{hint}'])->textInput(['maxLength' => true]) ?>
                <?= $form->field($order, 'customer_address', ['template' => '{input}{label}{error}{hint}'])->textarea(['maxLength' => true, 'rows' => 5]) ?>
                <?= $form->field($order, 'customer_note', ['template' => '{input}{label}{error}{hint}'])->textarea(['maxLength' => true, 'rows' => 5]) ?>
                <?= $form->field($order, 'handle_error')->hiddenInput()->label(false) ?>
                <button type="submit">Đặt hàng</button>
            <?php ActiveForm::end(); ?>
        </div>
    </section>
</div>

<script>
    var data = <?= json_encode($data) ?>;
    generateView();

    function updateQuantity(i, value) {
        data[i].quantity = value;
        updateCartData();
    }
    function removeFromCart(index) {
        for (var i = 0; i < data.length; i++) {
            if (i === index) {
                data.splice(i, 1);
                break;
            }
        }
        updateCartData();
    }
    function updateCartData()
    {
        var cart = [];
        for (var i = 0; i < data.length; i++) {
            cart.push({
                product_id: data[i].product_id,
                product_customization_id: data[i].product_customization_id,
                quantity: data[i].quantity
            });
        }
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (xhttp.readyState === 4 && xhttp.status === 200) {
                console.log(xhttp.responseText);
                if (parseInt(xhttp.responseText) > -1) {
                    updateCartCounter(xhttp.responseText);
                    generateView();
                }
            }
        };
        xhttp.open("POST", "<?= Url::to(['purchase-order/update-cart-data'], true) ?>");
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("CartData=" + JSON.stringify(cart)
            + "&<?= Yii::$app->request->csrfParam , '=' , Yii::$app->request->csrfToken; ?>");
        return true;
    }
    function generateView()
    {
        var view = {
            total_amount: document.getElementById("total-amount"),
            cart_data: document.getElementById("cart-data")
        };
        var total_amount = 0;
        while (view.cart_data.firstChild) {
            view.cart_data.removeChild(view.cart_data.firstChild);
        }
        data.forEach(function (item, index) {
            var tr = document.createElement("TR");
            view.cart_data.appendChild(tr);
            var tds = {};
            tds.image = document.createElement("TD");
            tds.desc = document.createElement("TD");
            tds.price = document.createElement("TD");
            tds.quantity = document.createElement("TD");
            tds.amount = document.createElement("TD");
            tds.remove = document.createElement("TD");
            for (var name in tds) {
                if (tds.hasOwnProperty(name)) {
                    tr.appendChild(tds[name]);
                    tds[name].className = name;
                }
            }

            var image = new Image();
            image.src = item.image;
            image.alt = item.product_name;
            tds.image.appendChild(image);

            var name = document.createElement("A");
            name.className = "name link";
            name.href = item.link;
            name.title = item.product_name;
            name.innerHTML = item.product_name;
            tds.desc.appendChild(name);

            var code = document.createElement("DIV");
            code.className = "code";
            code.innerHTML = "Mã SP: " + item.product_code + " - Tùy chọn: " + item.product_customization_name;
            tds.desc.appendChild(code);

            var price = document.createElement("SPAN");
            price.className = "long-vnd";
            price.innerHTML = item.price;
            tds.price.appendChild(price);

            var select = document.createElement("SELECT");
            for (var i = 1; i <= item.available_quantity && i <= 100; i++) {
                var option = document.createElement("OPTION");
                option.value = i;
                option.innerHTML = i;
                select.appendChild(option);
                if (i == item.quantity) {
                    option.selected = true;
                }
            }
            tds.quantity.appendChild(select);
            select.onchange = function () {
                updateQuantity(index, select.value);
                updateCartData();
            };

            var amount = document.createElement("SPAN");
            amount.className = "long-vnd";
            amount.innerHTML = item.quantity * item.price;
            tds.amount.appendChild(amount);

            var remove = document.createElement("BUTTON");
            remove.innerHTML = "<i class=\"icon remove-icon\"></i>";
            tds.remove.appendChild(remove);
            remove.onclick = function () {
                removeFromCart(index);
            };

            total_amount += item.quantity * item.price;
        });
        view.total_amount.innerHTML = total_amount;
        if (typeof formatNumbers === "function") {
            formatNumbers();
        }
    }
</script>