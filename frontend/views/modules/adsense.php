<?php
isset($type) or $type = 'square';
isset($class) or $class = '';
if ($type == 'square') {?>
<div style="text-align: center;">
    <ins class="adsbygoogle dspblock hdc-csi_square <?= $class ?>" style="display:inline-block;width:300px;height:250px" data-ad-client="ca-pub-3084353470359421" data-ad-slot="6924740593"></ins>
</div>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
<?php } else if ($type == 'auto') { ?>
    <ins class="adsbygoogle dspblock <?= $class ?>" data-ad-client="ca-pub-3084353470359421" data-ad-slot="5448007397" data-ad-format="auto"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
<?php } else if ($type == 'overlay') { ?>
    
<?php
}