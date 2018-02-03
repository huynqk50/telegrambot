/**
 * Created by Quyet on 10/20/2016.
 */

/*
 * Slideshow
 */
web.slideshow(document.getElementById("slideshow"), 3000);

/*
 * Set object orientation
 */
setObjectOrientation();
function setObjectOrientation() {
    web.setObjectOrientation(document.querySelectorAll(".aspect-ratio._7x2 .img-wrap :first-child"), 7 / 2);
    web.setObjectOrientation(document.querySelectorAll(".aspect-ratio._16x9 .img-wrap :first-child"), 16 / 9);
    web.setObjectOrientation(document.querySelectorAll(".aspect-ratio._5x3 .img-wrap :first-child"), 5 / 3);
    web.setObjectOrientation(document.querySelectorAll(".aspect-ratio._1x1 .img-wrap :first-child"), 1);
}

/*
 * Trim long text
 */
ellipsisTexts();
function ellipsisTexts() {
    web.ellipsisTexts(document.querySelectorAll("#home-featured .hot .intro"));
    web.ellipsisTexts(document.querySelectorAll("#home-cat ul li .intro"));
    web.ellipsisTexts(document.querySelectorAll(".grid-view > ul > li .name"));
    web.ellipsisTexts(document.querySelectorAll(".grid-view > ul > li .intro"));
    web.ellipsisTexts(document.querySelectorAll(".details-view li .name"));
    web.ellipsisTexts(document.querySelectorAll(".details-view li .intro"));
}

/*
 * View image when hover on it
 */
previewProductImages();
function previewProductImages() {
    !function (view, previews, active_class) {
        if (!view || !previews) {
            return;
        }
        var view_img = view.querySelector("img");
        if (!view_img) {
            return;
        }
        var remember_active_preview;
        [].forEach.call(previews, function (preview, idx) {
            !function (self) {
                var self_img = self.querySelector("img");
                if (!self_img) {
                    return;
                }
                if (idx === 0) {
                    view_img.src = self_img.src;
                    self.classList.add(active_class);
                    remember_active_preview = self;
                }

                self.onmouseover = function () {
                    view_img.src = self_img.src;
                    [].forEach.call(previews, function (preview) {
                        preview.classList.remove(active_class);
                    });
                    self.classList.add(active_class);
                };

                self.onmouseout = function () {
                    remember_active_preview.click();
                };

                self.onclick = function () {
                    view_img.src = self_img.src;
                    [].forEach.call(previews, function (preview) {
                        preview.classList.remove(active_class);
                    });
                    self.classList.add(active_class);
                    remember_active_preview = self;
                };
            }(preview);
            view.onclick = function () {
                [].forEach.call(previews, function (preview, idx) {
                    if (preview.classList.contains(active_class)) {
                        var imgs = [].map.call(previews, function (item) {
                            return item.querySelector("img");
                        });
                        web.popupImages(imgs, idx);
                        return;
                    }
                });
            };
        });
    }(
        document.querySelector(".product .images-n-desc .images .view"),
        document.querySelectorAll(".product .images-n-desc .images .previews .item"),
        "active"
    );
}

/*
 * Zoom product images
 */
web.zoomImages(
    document.querySelectorAll(".zoom-images img"),
    document.getElementById("zoom-area"),
    "data:image/gif;base64,R0lGODlhZABkAPABAHOf4fj48yH5BAEAAAEALAAAAABkAGQAAAL+jI+py+0PowOB2oqvznz7Dn5iSI7SiabqWrbj68bwTLL2jUv0Lvf8X8sJhzmg0Yc8mojM5kmZjEKPzqp1MZVqs7Cr98rdisOXr7lJHquz57YwDV8j3XRb/C7v1vcovD8PwicY8VcISDGY2GDIKKf4mNAoKQZZeXg5aQk5yRml+dgZ2vOpKGraQpp4uhqYKsgKi+H6iln7N8sXG4u7p2s7ykvnyxos/DuMWtyGfKq8fAwd5nzGHN067VUtiv2lbV3GDfY9DhQu7p1pXoU+rr5ODk/j7sSePk9Ub33PlN+4jx8v4JJ/RQQa3EDwzcGFiBLi6AfN4UOGCyXegGjIoh0fisQ0rsD4y+NHjgZFqgB5y2Qfks1UPmEZ0OVLlIcKAAA7"
);

/*
 * Product description tabs
 */
!function (tabs, paras) {
    if (!tabs || !paras) return;
    var active_class = "active";
    for (var i = 0; i < tabs.length; i++) {
        !function (tab, index) {
            tab.onclick = function () {
                [].forEach.call(tabs, function (tab) {
                    tab.classList.remove(active_class);
                });
                [].forEach.call(paras, function (para) {
                    para.classList.remove(active_class);
                });
                tab.classList.add(active_class);
                paras[index].classList.add(active_class);
            };
        }(tabs[i], i);
    }
}(
    document.querySelectorAll(".product .details-n-contact .tabs .tab"),
    document.querySelectorAll(".product .details-n-contact .paras .para")
);

/*
 * Format numbers
 */
formatNumbers();
function formatNumbers() {
    !function (numbers) {
        [].forEach.call(numbers, function (number) {
            if (isNaN(number.innerHTML)) {
                return;
            }
            number.innerHTML = web.abbreviateNumber(number.innerHTML).replace(/\./g, ",");
            number.style.visibility = "visible";
        });
    }(document.querySelectorAll(".number-kmb"));

    !function (numbers) {
        [].forEach.call(numbers, function (number) {
            if (isNaN(number.innerHTML)) {
                return;
            }
            var time = new Date(number.innerHTML * 1000);
            number.innerHTML = web.timeAgo(time, [" năm", " tháng", " ngày", " giờ", " phút", " giây"]);
            number.style.visibility = "visible";
        });
    }(document.querySelectorAll(".time-ago"));

    !function (numbers) {
        [].forEach.call(numbers, function (number) {
            if (isNaN(number.innerHTML)) {
                return;
            }
            var time = new Date(number.innerHTML * 1000);
            var options = {
                weekday: "long",
                year: "numeric",
                month: "numeric",
                day: "numeric"
    //                hour: "2-digit",
    //                minute: "2-digit"
            };
            number.innerHTML = time.toLocaleString("vi-VN", options);
            number.style.visibility = "visible";
        });
    }(document.querySelectorAll(".date-time"));

    !function (numbers) {
        [].forEach.call(numbers, function (number) {
            if (isNaN(number.innerHTML)) {
                return;
            }
            number.innerHTML = parseInt(number.innerHTML).formatVND();
            number.style.visibility = "visible";
        });
    }(document.querySelectorAll(".long-vnd"));

    !function (numbers) {
        [].forEach.call(numbers, function (number) {
            if (isNaN(number.innerHTML)) {
                return;
            }
            number.innerHTML = parseInt(number.innerHTML).formatVND(" đ");
            number.style.visibility = "visible";
        });
    }(document.querySelectorAll(".short-vnd"));
}

!function (ts) {
    [].forEach.call(ts, function (t) {
        web.toggleCheckboxes(t);
    });
}(document.querySelectorAll("form .toggle-checkboxes"));

!function (es) {
    [].forEach.call(es, function (e) {
        e.setAttribute("value", e.value);
        e.onkeyup =
        e.onkeydown =
        e.onchange =
        e.onclick =
        e.oninput =
        e.onpaste = function () {
            this.setAttribute("value", this.value);
        };
    });
}(document.querySelectorAll("form.primary input, form.primary textarea"));

// Content popup images
!function (imgs) {
    [].forEach.call(imgs, function (img, idx, arr) {
        img.onclick = function () {
            web.popupImages(arr, idx);
        };
    });
}(document.querySelectorAll(".content-popup-images img"));

// Cart counter
function updateCartCounter(value) {
    [].forEach.call(document.getElementsByClassName("cart-counter"), function (e) {
        e.innerHTML = value;
    });
}