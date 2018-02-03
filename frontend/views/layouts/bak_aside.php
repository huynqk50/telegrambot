<?php
use frontend\models\Video;
use frontend\models\Contact;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<aside class="right">
    <div class="contact-box">
        <div class="title">Nhận bài viết mới qua email và SĐT</div>
        <?php
        $contact = new Contact(['scenario' => 'email-and-phone_number']);
        if (Yii::$app->request->isPost && $contact->load(Yii::$app->request->post())) {
            $contact->created_at = time();
            $contact->status = Contact::STATUS_NEW;
            if ($contact->save()) {
                Yii::$app->session->setFlash('success', 'Đăng ký thành công. Cảm ơn bạn!');
                $contact = new Contact(['scenario' => 'email-and-phone_number']);
            } else {
                Yii::$app->session->setFlash('error', 'Đăng ký không thành công. Vui lòng thử lại hoặc liên hệ trực tiếp với chúng tôi!');
            }
        }
        $form = ActiveForm::begin(['options' => ['class' => 'clr primary']]);
        echo $form->field($contact, 'email')->textInput(['placeholder' => 'Nhập email của bạn...'])->label(false);
        echo $form->field($contact, 'phone_number')->textInput(['placeholder' => 'Nhập số điện thoại của bạn...'])->label(false);
        echo '<div class="form-group">' . Html::submitButton('SUBSCRIBE') . '</div>';
        ActiveForm::end();
        ?>
    </div>
    <div class="grid-view g2 aspect-ratio _16x9 video-text">
        <ul>
        <?php
        foreach (Video::find()->orderBy('published_at desc')->limit(6)->allPublished() as $item) {
            echo "<li>{$item->a([], '<div class="image"><div class="item-view"><div class="img-wrap">'
                                    . $item->img([], Video::IMAGE_SMALL) . '</div></div></div>'
                                    . '<h3 class="name">' . $item->name . '</h3>'
            )}</li>";
        }
        ?>
        </ul>
    </div>
</aside>