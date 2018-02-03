<style>
#send-email {
    background: #eee;
    padding-top: 20px;
    padding-bottom: 20px;
    
    margin-bottom: 1em;
    background-image: url("<?= \yii\helpers\Url::home(true), 'images/bg_email.jpg' ?>");
    background-repeat: no-repeat;
    background-position: center;
    background-size: cover;
}
#send-email form {
    width: 100%;
}
#send-email .title {
    display: block;
    width: 100%;
    text-align: center;
    text-transform: uppercase;
    font-weight: bold;
    font-size: 1.45em;
    line-height: 1.5em;
    color: #111;
    margin-bottom: 0.3em;
}
#send-email input {
    width: 100%;
    height: 3em;
    padding: 0 1em;
    border: none;
    border-radius: 0;
    transition: all 0.1s;
    box-shadow: 0 1px 2px rgba(0, 0, 0, .1);
    -webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, .1);
}
#send-email input:focus {
    box-shadow: 0 5px 10px rgba(0, 0, 0, .2);
    -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, .2);
}
#send-email input::-webkit-input-placeholder {
  color: #999;
}
#send-email input::-moz-placeholder {
  color: #999;
}
#send-email input:-ms-input-placeholder {
  color: #999;
}
#send-email input:-moz-placeholder {
  color: #999;
}
#send-email input:focus::-webkit-input-placeholder {
  color: #ddd;
}
#send-email input:focus::-moz-placeholder {
  color: #ddd;
}
#send-email input:focus:-ms-input-placeholder {
  color: #ddd;
}
#send-email input:focus:-moz-placeholder {
  color: #ddd;
}
#send-email button {
    height: 2.8em;
    padding: 0 1.4em;
    border: none;
    background: #111;
    color: #fff;
    font-weight: bold;
    text-transform: uppercase;
    cursor: pointer;
    display: block;
    margin: auto;
    margin-top: 1em;
}
#send-email .message {
    font-style: italic;
    font-size: 0.9em;
    margin-top: 0.2em;
}
#send-email .success {
    color: #2a0;
}
#send-email .fail {
    color: #e0221a;
}
.nowrap {
    white-space: nowrap;
}
</style>
<div class="container row">
    <div class="wrap">
        <div id="send-email" class="row">
            <div class="col-7"></div>
            <div class="col-4">
                <form class="row dsk-padl10 dsk-padr10" method="POST" action="<?= yii\helpers\Url::to(['contact/create-with-email'], true) ?>">
                    <div class="title">Đăng ký nhận khuyến mại <span class="nowrap">mới nhất</span></div>
                    <input type="text" name="email" placeholder="Nhập email của bạn">
                    <div class="message"></div>
                    <button type="submit" name="submit">Gửi</button>
                </form>
            </div>
            <div class="col-1"></div>
        </div>
    </div>
</div>
<script>
var form = document.querySelector("#send-email form");
var message = document.querySelector("#send-email .message");
form.onsubmit = function(event) {
    event.preventDefault();
    var email_input = form.querySelector("input[name=email]");
    var email = email_input.value;
    if (email === "") {
        return;
    }
    email_input.value = "";
    var url = form.action;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (xhttp.readyState === 4 && xhttp.status === 200) {
            console.log(xhttp.responseText);
            if (xhttp.responseText === "1") {
                message.classList.remove("fail");
                message.classList.add("success");
                message.innerHTML = "Email đã được gửi, cảm ơn bạn!";
            } else {
                message.classList.remove("success");
                message.classList.add("fail");
                message.innerHTML = "Không gửi được. Có thể email này đã tồn tại hoặc không đúng định dạng.";
            }
        }
    };
    xhttp.open("POST", url);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("email=" + email + "&<?= Yii::$app->request->csrfParam; ?>=<?= Yii::$app->request->csrfToken; ?>");
    return;
};
</script>