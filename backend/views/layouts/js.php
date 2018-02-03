<?php

use yii\helpers\Url;
use yii\web\View;

?>
<script src="<?= Yii::$app->homeUrl ?>admin-lte/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="<?= Yii::$app->homeUrl ?>jquery-ui/jquery-ui.min.js"></script>
<script src="<?= Yii::$app->homeUrl ?>admin-lte/bootstrap/js/bootstrap.min.js"></script>
<script src="<?= Yii::$app->homeUrl ?>admin-lte/dist/js/app.min.js"></script>
<script src="<?= Yii::$app->homeUrl ?>picture-cut/src/jquery.picture.cut.js"></script>
<script>
<?php $this->beginBlock('JS_END') ?>
    // Resolve conflict in jQuery UI tooltip with Bootstrap tooltip
    $.widget.bridge('uibutton', $.ui.button);
    
    // Picture Cut plugin
   //////////////////////
    $(".PictureCutImageContainer").each(function(){
        var PictureCutImageContainer = $(this);
        var InputName = PictureCutImageContainer.siblings("input").attr("id");
        PictureCutImageContainer.PictureCut({
            Extensions                  : ["jpg","jpeg","png","gif"],
            InputOfImageDirectory       : InputName,
            PluginFolderOnServer        : "<?= str_replace('//', '/', Yii::$app->homeUrl . '/picture-cut/') ?>",
            FolderOnServer              : "<?= str_replace('//', '/', str_replace(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']), '/', str_replace('\\', '/', Yii::$app->params['backend_folder']) . '/uploads/')) ?>",
            EnableCrop                  : true,
            CropWindowStyle             : "Bootstrap",
            ImageNameRandom             : false,
            MinimumWidthToResize        : 4096,
            MinimumHeightToResize       : 4096,
            MaximumSize                 : 4096,
            EnableMaximumSize           : false,
            UploadedCallback            : function(data){
                var image_name = data["currentFileName"];

                $.post(
                    "<?php echo Url::to(['file/check-file-exists'], true) ?>",
                    {
                        <?php echo Yii::$app->request->csrfParam; ?>: '<?php echo Yii::$app->request->csrfToken; ?>',
                        image_name: image_name,
                    },
                    function(d, textStatus, jqXHR) {
                        if (d === "1") {
                            alert("Ảnh bị trùng tên, vui lòng tải ảnh có tên khác!");
                        } else {
                            PictureCutImageContainer.siblings("input").val(image_name);
                            textCount(PictureCutImageContainer.siblings("input"), false);
                        }
                    }
                ).fail(function(jqXHR, textStatus, errorThrown){

                });
            }
        });
    });

    $(".PictureCutImageContainer.picture-element-principal").each(function(){
        $(this).width('auto').height('auto').css('text-align', 'center').css('border', 'none');
        $(this).children('form').children('input').width('100%').height('100%');
        $(this).children('form').children('img').height('100%');
    });
    
    $(document).bind('DOMNodeInserted', function(e) {
        // console.log(e.target, ' was inserted');
        <?php
            $arr_ip = Yii::$app->params['aspect_ratios'];
            $arr_op = [];
            foreach ($arr_ip as $label => &$val) {
                $val = number_format($val, 2, '.', ',');
                $arr_op[$val] = isset($arr_op[$val]) ? $arr_op[$val] . ", $label" : "$val = $label";
            }
            ksort($arr_op);
            $new_select = '<select id=new_select><option value=free selected=selected></option>';
            foreach ($arr_op as $val => $desc) {
                $new_select .= "<option value=$val>$desc</option>";
            }
            $new_select .= '</select>';
        ?>
        if (e.target.id === "SelectOrientacao") {
            var new_select = $("<?= $new_select ?>");
            var default_select = $("#SelectProporcao");
            var crop_box = $("#SelecaoRecorte");
            new_select.insertAfter(default_select);
            new_select.css({
                "width":"100%",
                "height":default_select.height() + "px",
                "border":default_select.css("border")
            });
            default_select.css({
                "width":"0px",
                "height":"0px",
                "border":"none",
                "position":"absolute",
                "visibility":"hidden"
            });
            default_select.html(default_select.children("option[value=livre]")); // important !!!
            default_select.prop("disabled",true);
            var x = 2; // x > 1
            new_select.change(function(){
                var r = new_select.val();
                if ($.isNumeric(r)) {
                    crop_box.unbind("resize");
                    var p = crop_box.parent();
                    crop_box.css("max-width", p.width());
                    crop_box.css("max-height", p.height());
                    if (p.width() / p.height() <= x * r) {
                        crop_box.css("width", "calc(" + String(100 * (1 / x)) + "%)");
                        crop_box.css("height", crop_box.width() / r + "px");
                    } else {
                        crop_box.css("height", "calc(" + String(100 * (1 / x)) + "%)");
                        crop_box.css("width", crop_box.height() * r + "px");
                    }
                    crop_box.resize(function(){
                        var height = (crop_box.width() / r) + "px";
                        var width = (crop_box.height() * r) + "px";
                        crop_box.height(height);
                        crop_box.width(width);
                        if (parseInt(crop_box.css("top")) + parseInt(crop_box.height()) > parseInt(p.height()) ) {
                            crop_box.css("top", parseInt(p.height()) - parseInt(crop_box.height()) + "px");
                        }
                        if (parseInt(crop_box.css("left")) + parseInt(crop_box.width()) > parseInt(p.width()) ) {
                            crop_box.css("left", parseInt(p.width()) - parseInt(crop_box.width()) + "px");
                        }
                    });
                } else {
                    crop_box.unbind("resize");
                }
            });
        }
    });
    
    // Auto generate value for some inputs
   ///////////////////////////////////////
    $("input:text, textarea").each(function(){
        var ip = $(this);
        if (ip.attr('name').indexOf('[name]') != -1
//        || ip.attr('name').indexOf('[page_title]') != -1
//        || ip.attr('name').indexOf('[h1]') != -1
//        || ip.attr('name').indexOf('[meta_title]') != -1
        ) {
            ip.change(function(){
                $("input:text, textarea").each(function(){
                    var item = $(this);
//                    if (item.val() == "") {
                        if (item.attr('name').indexOf('[name]') != -1
                        || item.attr('name').indexOf('[page_title]') != -1
                        || item.attr('name').indexOf('[h1]') != -1
                        || item.attr('name').indexOf('[meta_title]') != -1
                        ) {
                            item.val(ip.val());
                            textCount(item, false);
                        } else if (item.attr('name').indexOf('[meta_keywords]') != -1) {
//                            item.val(get_keywords(ip.val()));
//                            textCount(item, false);
                        } else if (item.attr('name').indexOf('[slug]') != -1) {
                            if (item.val() == "") {
                                item.val(special_chars_filter(vi_str_filter(ip.val())));
                                textCount(item, false);
                            }
                        }
//                    }
                });
                $("select").find("option").each(function(){
                    var item = $(this);
                    if (item.parents("select").val() == "") {
                        if (vi_str_filter(ip.val()).indexOf(vi_str_filter(item.html())) != -1) {
                            item.parents("select").val(item.val());
                            item.parents(".form-group").toggleClass("has-warning");
                            return false;
                        }
                    }
                });
            });
        }
        
        if (ip.attr('name').indexOf('[description]') != -1
        || ip.attr('name').indexOf('[meta_description]') != -1
        ) {
            ip.change(function(){
                $("input:text, textarea").each(function(){
                    var item = $(this);
//                    if (item.val() == "") {
                        if (item.attr('name').indexOf('[description]') != -1
                        || item.attr('name').indexOf('[meta_description]') != -1
                        ) {
                            item.val(ip.val());
                            textCount(item, false);
                        }
//                    }
                });
            });
        }
        
//        if (ip.attr('name').indexOf('[meta_keywords]') != -1) {
//            var meta_keywords_selected = false;
//            ip.click(function(){
//                if (!meta_keywords_selected) {
//                    $(this).select();
//                    meta_keywords_selected = true;
//                }
//            });
//        }
    });
    
    $("input:text, textarea").each(function(){
        textCount($(this));
    });
    
    $("select").click(function(){
        $(this).parent(".form-group").removeClass("has-warning");
    });
    
    function textCount(ip, onEvent){
        onEvent = typeof onEvent !== "undefined" ? onEvent : true;
        
        var label = ip.siblings("label");
        if (!label.next().is("code")) {
            $("<code></code>").insertAfter(label);
        }
        var counter = label.next("code");
        if (onEvent) {
            ip.bind("change paste keydown keyup keypress mousemove click select", function(){
                var len = ip.val().length;
                if (len > 0) {
                    counter.html(" " + len);
                } else {
                    counter.html("");
                }
            });
        } else {
            var len = ip.val().length;
            if (len > 0) {
                counter.html(" " + len);
            } else {
                counter.html("");
            }
        }
    }
    
    function vi_str_filter(str) {
        str = str.toLowerCase();
        str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
        str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
        str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
        str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
        str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
        str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
        str = str.replace(/đ/g, "d");
        return str;
    }
    
    function special_chars_filter(str) {
        
        var special_chars = [];
        
        for (var i = 0; i < str.length; i++) {
            if (!/^[a-zA-Z0-9- ]*$/.test(str[i])) {
                has = false;
                if (!/^[/_.,]*$/.test(str[i])) {
                    for (var j = 0; j < special_chars.length; j++) {
                        if (special_chars[j].char == str[i]) {
                            special_chars[j].count += 1;
                            has = true;
                            break;
                        }
                    }
                    if (!has) {
                        special_chars.push({char:str[i], count:1});
                    }
                }
                str = str.substr(0, i) + " " + str.substr(i + 1);
            }
        }
        
        if (special_chars.length > 0) {
            var msg = "Phát hiện ký tự đặc biệt: \n";
            for (var i = 0; i < special_chars.length; i++) {
                msg += "\n     " + special_chars[i].char + "     (" + special_chars[i].count + " lần)";
            }
            msg += "\n\n Vui lòng kiểm tra Slug.";
            
            alert(msg);
        }
        
        str = str.trim();
        str = str.replace(/ /g, "-");
        while (str.indexOf("--") !== -1) {
            str = str.replace(/--/g, "-");
        }
        
        return str;
    }
    
    function get_keywords(str) {
        if (vi_str_filter(str) === str) {
            return str;
        } else {
            return str + ", " + vi_str_filter(str);
        }
    }
    
    // Add submit button 2
   ///////////////////////
//    var form_ = $(".form-group:has(button:submit)");
//    var submit_bt = form_.children("button:submit:last-child");
//    var submit_bt2 = submit_bt.clone();
//    submit_bt.attr("id", "submit_bt");
//    submit_bt2.removeClass().removeAttr();
//    submit_bt2.css("background-color", submit_bt.css("background-color")).css("color", submit_bt.css("color"));
//    submit_bt2.attr("id", "submit_bt2");
//    $(form_).append(submit_bt2);
//    
//    $(submit_bt2).click(function(event){
//        var time = 0.5;
//        var color = "transparent";
//        var color2 = $(this).css("background-color");
//        var h = 10;
//        var h2 = 100;
//        var w = 10;
//        var w2 = 100;
//        var x = event.pageX;
//        var y = event.pageY;
//        $.when(fn1()).then(fn2());
//        function fn1() {
//            var ele = "<div id=\"mouse_point\" style=\"left:" + (x - w/2) + "px;top:" + (y - h/2) + "px;border-radius:100%;height:" + h + "px;width:" + w + "px;background:" + color + ";position:absolute;transition:all " + time + "s;\"></div>";
//            $("html").append(ele);
//        }
//        function fn2() {
//            fn21();
//            setTimeout(function(){
//                fn22();
//            }, 1000 * time);
//        }
//        function fn21() {
//            $("#mouse_point").width(w2 + "px").height(h2 + "px");
//            $("#mouse_point").css("margin-top", (h - h2)/2 + "px").css("margin-left", (w - w2)/2 + "px");
//            $("#mouse_point").css("border", (h2 - h)/7 + "px solid " + color2);
//            $("#mouse_point").css("opacity", 0);
//        }
//        function fn22() {
//            $("#mouse_point").remove();
//        }
//    });
    
<?php $this->endBlock(); ?>    
</script>
<?php  
$this->registerJs($this->blocks['JS_END'], View::POS_END);
