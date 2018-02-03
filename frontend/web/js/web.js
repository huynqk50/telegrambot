/**
 * Created by Quyet on 10/12/2016.
 */

var web = {};

web.toggleElement = function (e) {
    var s = window.getComputedStyle(e, null).getPropertyValue("display");
    if (s === "block") {
        e.style.display = "none";
    } else {
        e.style.display = "block";
    }
};

web.toggleClassName = function (e, className) {
    if (e.classList.contains(className)) {
        e.classList.remove(className);
    } else {
        e.classList.add(className);
    }
};

web.scrollTop = function () {
    var scrollTop;
    if (typeof(window.pageYOffset) === "number") {
        // DOM compliant, IE9+
        scrollTop = window.pageYOffset;
    }
    else {
        // IE6-8 workaround
        if (document.body && document.body.scrollTop) {
            // IE quirks mode
            scrollTop = document.body.scrollTop;
        }
        else if (document.documentElement && document.documentElement.scrollTop) {
            // IE6+ standards compliant mode
            scrollTop = document.documentElement.scrollTop;
        }
    }
    return scrollTop;
};

web.popup = function (msg) {
    var cls = "popup";

    if (msg === (document.querySelector("." + cls + " .message") || {}).innerHTML) {
        return;
    }

    var style = document.createElement("style");
    var popup = document.createElement("div");
    var modal = document.createElement("div");
    var content = document.createElement("div");
    var message = document.createElement("div");

    style.innerHTML = [
        ".", cls, "{position:fixed;top:0;bottom:0;left:0;right:0;z-index:99999}",
        ".", cls, " .content, .", cls, " .modal{position:absolute;top:0;bottom:0;left:0;right:0}",
        ".", cls, " .modal{background:#000;opacity:.7}",
        ".", cls, " .content{margin:auto;background:#fff;border-radius:3px;box-sizing:content-box;padding:1vw;border:1px solid #ccc;max-width:calc(98vw - 2vw - 2px);max-height:calc(98vh - 2vw - 2px)}",
        ".", cls, " .message{display:table}"
    ].join("");

    popup.className = cls;
    modal.className = "modal";
    content.className = "content";
    message.className = "message";

    popup.disappear = function () {
        popup.parentNode.removeChild(popup);
    };
    modal.onclick = popup.disappear;

    message.innerHTML = msg;

    content.appendChild(message);

    popup.appendChild(style);
    popup.appendChild(modal);
    popup.appendChild(content);

    document.body.appendChild(popup);

    popup.resize = function () {
        content.style.width = message.offsetWidth + "px";
        content.style.height = message.offsetHeight + "px";
    };
    popup.resize();
    window.onresize = popup.resize;

    return popup;
};

web.slideshow = function (slideshow, time) {
    if (!slideshow) return;
    if (!time) time = 5000;

    var photos = slideshow.getElementsByClassName("photos")[0];
    var bullets = slideshow.getElementsByClassName("bullets")[0];

    var prev_button = slideshow.getElementsByClassName("prev-button")[0];
    var next_button = slideshow.getElementsByClassName("next-button")[0];

    if (prev_button && next_button) {
        prev_button.addEventListener("click", prev);
        next_button.addEventListener("click", next);
    }

    var number = photos.children.length;
    var current_index = 0;

    function prev() {
        if (current_index === 0) {
            current_index = number - 1;
        } else {
            current_index--;
        }

        setActiveClass(current_index);
    }

    function next() {
        if (current_index === number - 1) {
            current_index = 0;
        } else {
            current_index++;
        }

        setActiveClass(current_index);
    }

    if (bullets) {
        for (var i = 0; i < number; i++) {
            var bullet = document.createElement("b");
            !function (index) {
                bullet.onclick = function () {
                    setActiveClass(index);
                };
            }(i);

            bullets.appendChild(bullet);
        }
    }

    var active_class = "active";
    function setActiveClass(index) {
        for (var i = 0; i < number; i++) {
            var photo = photos.children[i];
            if (!photo) {
                return;
            }
            var method = i === index ? "add" : "remove";
            photo.classList[method](active_class);
            if (bullets) {
                bullets.children[i].classList[method](active_class);
            }
        }
    }

    var autorun = setInterval(next, time);
    slideshow.onmouseout = function () {
        autorun = setInterval(next, time);
    };
    slideshow.onmouseover = function () {
        clearInterval(autorun);
    };

    setActiveClass(0);
};

web.setObjectOrientation = function (objects, aspect_ratio, bool) {
    if (typeof bool === "undefined" || bool) {
        for (var i = 0; i < objects.length; i++) {
            !function main(obj) {
                var width = obj.naturalWidth || obj.width;
                var height = obj.naturalHeight || obj.height;

                if (width / height > aspect_ratio) {
                    obj.classList.add("landscape");
                    obj.classList.remove("portrait");
                } else {
                    obj.classList.add("portrait");
                    obj.classList.remove("landscape");
                }
                if (typeof obj.onload !== "undefined" && !obj.loaded) {
                    obj.onload = function () {
                        main(this);
                        obj.loaded = true;
                    };
                }
            }(objects[i]);
        }
    }
};

web.previewFile = function (preview, file) {
    var reader = new FileReader();

    reader.addEventListener("load", function () {
        preview.src = reader.result;
    }, false);

    if (file) {
        reader.readAsDataURL(file);
    }
};

web.popupImages = function (arr, idx) {
    if (!arr) return;
    if (!idx) idx = 0;

    var popup = web.popup(
        "<img src='" + arr[idx].src + "' id='image' style='max-width:calc(98vw - 2vw - 2px);max-height:calc(98vh - 2vw - 2px)'>" +
        "<button type='button' id='prev-btn'><i class='icon prev-icon'></i></button>" +
        "<button type='button' id='next-btn'><i class='icon next-icon'></i></button>" +
        "<button type='button' id='close-btn'><i class='icon close-icon'></i></button>"
    );
    var image = popup.querySelector("#image");
    var next_btn = popup.querySelector("#next-btn");
    var prev_btn = popup.querySelector("#prev-btn");
    var close_btn = popup.querySelector("#close-btn");
    next_btn.onclick = function () {
        if (!arr[++idx]) {
            idx = 0;
        }
        changeImage(idx);
    };
    prev_btn.onclick = function () {
        if (!arr[--idx]) {
            idx = arr.length - 1;
        }
        changeImage(idx);
    };
    function changeImage(idx) {
        image.src = arr[idx].src;
        popup.resize();
    }
    close_btn.onclick = popup.disappear;
};

web.ellipsisText = function (e, etc) {
    var wordArray = e.innerHTML.split(" ");
    while (e.scrollHeight > e.offsetHeight) {
        wordArray.pop();
        e.innerHTML = wordArray.join(" ") + (etc || "...");
    }
};

web.ellipsisTexts = function (es, etc) {
    [].forEach.call(es, function (e) {
        e.myText = e.innerHTML;
    });
    main();
    window.onresize = main;
    function main () {
        [].forEach.call(es, function (e) {
            e.innerHTML = e.myText;
            web.ellipsisText(e, etc);
        });
    }
};

web.zoomImages = function (imgs, zoom, lens_bg) {
    if (!imgs || !zoom || window.getComputedStyle(zoom, null).getPropertyValue("display") === "none") {
        return;
    }
    var magnifier = document.createElement("div");
    magnifier.style.display = "none";
    magnifier.style.position = "fixed";
    magnifier.style.pointerEvents = "none";
    magnifier.style.backgroundImage = lens_bg ? "url('" + lens_bg + "')" : "";
    magnifier.style.backgroundRepeat = "repeat";
    document.body.appendChild(magnifier);

    [].forEach.call(imgs, function (img) {
        img.onmousemove = function (event) {
            event = window.event || event;
            var image = zoom.querySelector("img");
            if (!image) {
                image = new Image();
                image.src = this.src;
                image.style.position = "absolute";
                zoom.appendChild(image);
            }
            var rect = this.getBoundingClientRect();
            var x = event.clientX - rect.left;
            var y = event.clientY - rect.top;
            image.style.left = (zoom.clientWidth / 2) - (x / rect.width) * image.width + "px";
            image.style.top = (zoom.clientHeight / 2) - (y / rect.height) * image.height + "px";
            var mag_wid = zoom.clientWidth * rect.width / image.width;
            var mag_hei = zoom.clientHeight * rect.height / image.height;
            magnifier.style.width = mag_wid + "px";
            magnifier.style.height = mag_hei + "px";
            magnifier.style.left = event.clientX - mag_wid / 2 + "px";
            magnifier.style.top = event.clientY - mag_hei / 2 + "px";
            magnifier.style.display = "block";
        };
        img.onmouseout = function () {
            while (zoom.firstChild) {
                zoom.removeChild(zoom.firstChild);
            }
            magnifier.style.display = "none";
        };
    });
};

web.abbreviateNumber = function (number, decimals, abbrev) {
    // Copy from: http://stackoverflow.com/questions/10599933/convert-long-number-into-abbreviated-string-in-javascript-with-a-special-shortn
    // Auth: http://stackoverflow.com/users/179216/jeff-b

    // 2 decimal places => 100, 3 => 1000, etc
    if (!decimals) decimals = 1;
    decimals = Math.pow(10, decimals);

    // Enumerate number abbreviations
    if (!abbrev) abbrev = ["k", "m", "b", "t"];

    // Go through the array backwards, so we do the largest first
    for (var i = abbrev.length - 1; i >= 0; i--) {

        // Convert array index to "1000", "1000000", etc
        var size = Math.pow(10, (i + 1) * 3);

        // If the number is bigger or equal do the abbreviation
        if (size <= number) {
            // Here, we multiply by decimals, round, and then divide by decimals.
            // This gives us nice rounding to a particular decimal place.
            number = Math.round(number * decimals / size) / decimals;

            // Handle special case where we round up to the next abbreviation
            if ((number == 1000) && (i < abbrev.length - 1)) {
                number = 1;
                i++;
            }

            // Add the letter for the abbreviation
            number += abbrev[i];

            // We are done... stop
            break;
        }
    }

    return number;
};

web.timeAgo = function (date, units) {
    if (!units) {
        units = [
            " years",
            " months",
            " days",
            " hours",
            " minutes",
            " seconds"
        ];
    }

    var seconds = Math.floor((new Date() - date) / 1000);
    var interval = Math.floor(seconds / 31536000);

    if (interval > 1) {
        return interval + units[0];
    }
    interval = Math.floor(seconds / 2592000);
    if (interval > 1) {
        return interval + units[1];
    }
    interval = Math.floor(seconds / 86400);
    if (interval > 1) {
        return interval + units[2];
    }
    interval = Math.floor(seconds / 3600);
    if (interval > 1) {
        return interval + units[3];
    }
    interval = Math.floor(seconds / 60);
    if (interval > 1) {
        return interval + units[4];
    }

    return Math.floor(seconds) + units[5];
};

!function () {
    Number.prototype.formatNumber = function(c, d, t){
        var n = this,
            c = isNaN(c = Math.abs(c)) ? 2 : c,
            d = d == undefined ? "." : d,
            t = t == undefined ? "," : t,
            s = n < 0 ? "-" : "",
            i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
            j = (j = i.length) > 3 ? j % 3 : 0;
        return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
    };

    Number.prototype.formatVND = function (suffix) {
        return this.formatNumber(0, ",", ".") + (suffix || " VNĐ");
    }
}();

web.toggleCheckboxes = function (self) {
    var checkboxes = self.form.querySelectorAll("input[type='checkbox'][name='" + self.name + "']");
    [].forEach.call(checkboxes, function(checkbox) {
        checkbox.onchange = function () {
            if (checkbox === self) {
                [].forEach.call(checkboxes, function(checkbox) {
                    checkbox.checked = self.checked;
                });
            } else {
                self.checked = true;
                [].forEach.call(checkboxes, function (checkbox) {
                    if (!checkbox.checked) {
                        self.checked = false;
                        throw new Error;
                    }
                });
            }
        };
    });
};