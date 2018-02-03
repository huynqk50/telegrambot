<?php
use frontend\models\SiteParam;
use yii\helpers\Url;
?>
<div class="left">
    <?= $this->render('//modules/breadcrumb') ?>
    <section class="product">
        <section class="clr">
            <h1 class="name"><?= "$model->name &minus; mã $model->code" ?></h1>
            <div class="info">
                <em><span class="date-time"><?= $model->published_at ?></span></em>
                | <em><span class="icon comment-icon"></span> <?= $model->comment_count ?> bình luận</em>
                | <em><span class="icon view-icon"></span> <span class="number-kmb"><?= $model->view_count ?></span> xem</em>
            </div>
            <div class="like-share">
                <div class="google-plus"></div>
                <div class="facebook"></div>
            </div>
        </section>
        <section class="clr images-n-desc">
            <div class="left">
                <div class="images">
                    <div class="view zoom-images">
                        <div class="img-wrap">
                            <?= $model->img() ?>
<!--                            <img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" alt="view">-->
                        </div>
                    </div>
                    <div class="previews grid-view g5 aspect-ratio _1x1 popup-images">
                        <div class="content" id="product-images">
                            <?php /*
                            foreach ($images as $img) {
                                ?><div class="item">
                                    <div class="item-view">
                                        <div class="img-wrap">
                                            <?= $img ?>
                                        </div>
                                    </div>
                                </div><?php
                            } */
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="right">
                <form id="product-form" method="POST" action="<?= Url::to(['purchase-order/add-to-cart']) ?>">
                    <input type="hidden" name="<?= Yii::$app->request->csrfToken ?>" value="<?= Yii::$app->request->csrfParam ?>">
                    <input type="hidden" name="product-id" id="product-id" value="<?= $model->id ?>">
                    <input type="hidden" name="product-customization-id" id="product-customization-id">
                    <div class="form-group price">
                        <b>Giá:</b>
                        <b class="sale long-vnd" id="product-price"></b>
                        <s class="orign long-vnd" id="product-original-price"></s>
                    </div>
                    <?php
                    foreach ($model->getProductAttributes()->orderBy('sort_order asc')->with('group')->all() as $item) {
                        ?>
                        <div class="form-group">
                            <b><?= $item->group->name ?>:</b> <span><?= $item->label != '' ? $item->label : $item->name ?></span>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="form-group" id="product-option-groups"></div>
                    <div class="form-group">
                        <b>Tình trạng:</b> <span id="product-stock-status"><?= $model->isStockAvailable() ? 'Còn hàng' : 'Hết hàng' ?></span>
                    </div>
                    <div class="form-group">
                        <b>Số lượng đặt mua:</b>
                        <select name="quantity" id="product-quantity"></select>
                        <button type="submit">Đặt hàng</button>
                    </div>
                </form>
                <div class="contact">
                    <h3 class="title">Liên hệ mua hàng</h3>
                    <div class="content">
                        <a href="tel:<?= ($phone = SiteParam::findOneByName(SiteParam::PARAM_PHONE_NUMBER)) ? $phone->value : '' ?>" title="Hotline"><i class="icon hotline-icon"></i> <?= $phone ? $phone->value : '' ?></a>
                        <a href="skype:<?= ($skype = SiteParam::findOneByName(SiteParam::PARAM_SKYPE)) ? $skype->value : '' ?>?call" title="Skype"><i class="icon skype-icon"></i> <?= $skype ? $skype->value : '' ?></a>
                        <br>
                        <a href="<?= ($fb = SiteParam::findOneByName(SiteParam::PARAM_FACEBOOK)) ? $fb->value : 'javascript:;' ?>" title="Facebook" target="_blank"><i class="icon fb-msg-icon"></i> Tư vấn <span class="text-dark-blue">Facebook</span></a>
                    </div>
                </div>
                <div id="zoom-area"></div>
            </div>
        </section>
        <section class="clr details-n-contact">
            <div class="clr tabs">
                <div class="tab active">Chi tiết sản phẩm</div>
                <div class="tab">Thông tin liên hệ</div>
            </div>
            <div class="paras">
                <article class="fit-content para active content-popup-images">
                    <?= $model->content ?>
                </article>
                <article class="fit-content para">
                </article>
            </div>
        </section>
    </section>
    <section class="clr">
        <?= $this->render('//modules/comment') ?>
    </section>
    <section class="clr">
        <h3 class="title">Sản phẩm tương tự</h3>
        <div class="content aspect-ratio _1x1">
            <section class="product-text grid-view g4 md-g3 sm-g2">
                <div class="content">
                    <?= $this->render('items', ['models' => $related_items]) ?>
                </div>
            </section>
        </div>
    </section>
</div>
<?= $this->render('//layouts/aside') ?>

<script>
!function () {
    var messages = {
        sold_out: "Hết hàng",
        in_stock: "Còn hàng"
    };
    var config = {
        getProductOptionInputName: function (key) {
            return "product-option-group-" + key;
        },
        getProductOptionInputValue: function (key) {
            return key;
        }
    };
    var view = {
        id: document.getElementById("product-id"),
        customization_id: document.getElementById("product-customization-id"),
        option_groups: document.getElementById("product-option-groups"),
        images: document.getElementById("product-images"),
        price: document.getElementById("product-price"),
        original_price: document.getElementById("product-original-price"),
        quantity: document.getElementById("product-quantity"),
        stock_status: document.getElementById("product-stock-status"),
        form: document.getElementById("product-form")
    };
    console.log("var view:");
    console.log(view);

    var common_price = <?= (float) $model->price ?>;
    var common_original_price = <?= (float) $model->original_price ?>;

    var option_groups = <?= json_encode($option_groups) ?>;
    console.log("var option_groups:");
    console.log(option_groups);

    var customizations = {};
    var current_customization = {model:{}};
    var option_inputs = [];

    for (var group_id in option_groups) {
        if (!option_groups.hasOwnProperty(group_id)) {
            continue;
        }
        var group = option_groups[group_id];

        var form_group = document.createElement("DIV");
        form_group.className = "form-group";

        var form_group_name = document.createElement("B");
        form_group_name.innerHTML = group.model.label || (group.model.name + ":");
        form_group.appendChild(form_group_name);

        for (var option_id in group.options) {
            if (!group.options.hasOwnProperty(option_id)) {
                continue;
            }
            var option = group.options[option_id];

            // @TODO: Initializes customization into customizations variable
            for (var customization_id in option.customizations) {
                if (option.customizations.hasOwnProperty(customization_id)) {
                    customizations[customization_id] = option.customizations[customization_id];
                }
            }

            var radio = document.createElement("LABEL");
            radio.className = "radio";

            var radio_input = document.createElement("INPUT");
            radio_input.type = "radio";
            radio_input.name = config.getProductOptionInputName(group.model.id);
            radio_input.value = config.getProductOptionInputValue(option.model.id);
            radio.appendChild(radio_input);

            var radio_appearance = document.createElement("B");
            radio.appendChild(radio_appearance);

            var radio_text = document.createElement("SPAN");
            radio_text.innerHTML = option.model.label || ("&nbsp;" + option.model.name);
            radio.appendChild(radio_text);

            // @TODO: Appends radio into form group
            form_group.appendChild(radio);

            // @TODO: Listens to change event on radio input
            radio_input.onchange = function () {
                // @TODO: Initializes value true for passed property of each customization
                for (var customization_id in customizations) {
                    if (customizations.hasOwnProperty(customization_id)) {
                        customizations[customization_id].passed = true;
                    }
                }

                // @TODO: Groups radio inputs by them name
                var input_groups = {};
                option_inputs.forEach(function (input) {
                    if (typeof input_groups[input.name] === "undefined") {
                        input_groups[input.name] = [];
                    }
                    input_groups[input.name].push(input);
                });

                // @TODO: For each radio input group
                for (var input_name in input_groups) {
                    if (!input_groups.hasOwnProperty(input_name)) {
                        continue;
                    }
                    var checked = false;
                    input_groups[input_name].forEach(function (input) {
                        if (input.checked) {
                            checked = true;
                            return;
                        }
                    });

                    // @TODO: Determine value for passed property of customizations of option
                    // @TODO: ...if radio input group has a checked radio
                    if (checked) {
                        input_groups[input_name].forEach(function (input) {
                            if (!input.checked) {
                                for (var customization_id in input.option.customizations) {
                                    if (input.option.customizations.hasOwnProperty(customization_id)) {
                                        customizations[customization_id].passed = false;
                                    }
                                }
                            }
                        });
                    }
                }

                view.refreshContent();
                view.refreshContentByCustomization();
            };

            // @TODO: Get product option from radio input
            radio_input.option = option;

            // @TODO: Adds input to option inputs array
            option_inputs.push(radio_input);
        }

        // @TODO: Appends form group into view
        view.option_groups.appendChild(form_group);
    }

    // @TODO: Initializes value true for passed property of each customization
    for (var customization_id in customizations) {
        if (customizations.hasOwnProperty(customization_id)) {
            customizations[customization_id].passed = true;
        }
    }

    // @TODO: Generates views for selected customizations
    view.refreshContent = function () {
        // @TODO: Get passed customizations
        var passed_customizations = [];
        for (var customization_id in customizations) {
            if (customizations.hasOwnProperty(customization_id) && customizations[customization_id].passed) {
                passed_customizations.push(customizations[customization_id]);
            }
        }
        // @TODO: Refresh images
        !function () {
            while (view.images.firstChild) {
                view.images.removeChild(view.images.firstChild);
            }
            passed_customizations.forEach(function (customization, idx) {
                if (idx === 0) {
                    current_customization = customization;
                }
                for (var image_id in customization.images) {
                    if (!customization.images.hasOwnProperty(image_id)) {
                        continue;
                    }

                    var item = document.createElement("DIV");
                    item.className = "item";
                    view.images.appendChild(item);

                    var item_view = document.createElement("DIV");
                    item_view.className = "item-view";
                    item.appendChild(item_view);

                    var img_wrap = document.createElement("DIV");
                    img_wrap.className = "img-wrap";
                    item_view.appendChild(img_wrap);

                    var image = customization.images[image_id];
                    var img = new Image();
                    img.src = image.source;
                    img_wrap.appendChild(img);

                    // @TODO: Attach corresponding customization to img
                    img.customization = customization;

                    // @TODO: Change current customization by attached customization of each img
                    img.addEventListener("click", function () {
                        current_customization = this.customization;
                        view.refreshContentByCustomization();
                    });
                }
            });

            // This function is declared in main.js
            if (typeof previewProductImages === "undefined") {
                window.addEventListener("load", function () {
                    previewProductImages();
                });
            } else {
                previewProductImages();
            }
        }();

        // @TODO: Refresh stock status
        !function () {
            var available_quantity = 0;
            passed_customizations.forEach(function (customization) {
                available_quantity += customization.model.available_quantity;
            });

            if (available_quantity > 0) {
                view.stock_status.innerHTML = messages.in_stock;
            } else {
                view.stock_status.innerHTML = messages.sold_out;
            }

            // @TODO: Refresh product quantity select box
            while (view.quantity.firstChild) {
                view.quantity.removeChild(view.quantity.firstChild);
            }
            for (var i = 1; i <= 100 && i <= available_quantity; i++) {
                var select_option = document.createElement("OPTION");
                select_option.value = i;
                select_option.innerHTML = i;
                view.quantity.appendChild(select_option);
            }

        }();

        // @TODO: Refresh price and original price
        !function () {
            var price = common_price;
            var original_price = common_original_price;
            if (passed_customizations.length === 1) {
                var customization = passed_customizations[0];
                price = parseFloat(customization.model.price);
                if (price) {
                    original_price = parseFloat(customization.model.original_price) || price;
                } else {
                    price = common_price;
                }
            }
            view.price.innerHTML = price;
            view.original_price.innerHTML = original_price;
            view.original_price.style.display = original_price <= price ? "none" : "initial";

            // This function was declared in main.js
            if (typeof formatNumbers === "undefined") {
                window.addEventListener("load", function () {
                    formatNumbers();
                });
            } else {
                formatNumbers();
            }
        }();

    };

    view.refreshContent();

    view.refreshContentByCustomization = function () {
        view.customization_id.value = current_customization.model.id;
    };

    view.refreshContentByCustomization();

    view.form.addEventListener("submit", function (event) {
        event.preventDefault();
        var data = {
            product_id: view.id.value,
            product_customization_id: view.customization_id.value,
            quantity: view.quantity.value
        };
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (xhttp.readyState === 4 && xhttp.status === 200) {
                console.log(xhttp.responseText);
                if (parseInt(xhttp.responseText) > 0) {
                    location.href = "<?= Url::to(['purchase-order/cart-checkout'], true) ?>";
                }
            }
        };
        xhttp.open(view.form.method, view.form.action);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("CartItem=" + JSON.stringify(data) + "&<?= Yii::$app->request->csrfParam; ?>=<?= Yii::$app->request->csrfToken; ?>");
        return false;
    });
}();

</script>
