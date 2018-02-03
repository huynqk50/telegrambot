<div id="fb-root"></div>
<script>
    <?php
    if (Yii::$app->session->hasFlash('success')) {
        echo 'web.popup("' . Yii::$app->session->getFlash('success') . '");';
    }
    if (Yii::$app->session->hasFlash('error')) {
        echo 'web.popup("' . Yii::$app->session->getFlash('error') . '");';
    }
    if (Yii::$app->session->hasFlash('message')) {
        echo 'web.popup("' . Yii::$app->session->getFlash('message') . '");';
    }
    ?>
</script>

<!-- Google (Like buttons .... ) -->
<script src="https://apis.google.com/js/platform.js" async defer></script>

<script>
// Google Analytics
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', '<?= Yii::$app->params['ga_id'] ?>', 'auto');
ga('send', 'pageview');

// Google Search
(function() {
  var cx = '<?= Yii::$app->params['gcse_cx'] ?>';
  var gcse = document.createElement('script');
  gcse.type = 'text/javascript';
  gcse.async = true;
  gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
      '//cse.google.com/cse.js?cx=' + cx;
  var s = document.getElementsByTagName('script')[0];
  s.parentNode.insertBefore(gcse, s);
})();
  
// Facebook SDK
(function(d, s, id){
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement(s); js.id = id;
    // js.src = "//connect.facebook.net/en_US/sdk.js";
    js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.6&appId=<?= Yii::$app->params['fb_app_id'] ?>";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

</script>