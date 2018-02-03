<?= '<?xml version="1.0" encoding="UTF-8"?>' ?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <?php
    foreach ($items as $item) {
    ?>
    <sitemap>
        <loc><?= $item ?></loc>
        <lastmod><?= date('c', time()) ?></lastmod>
    </sitemap>
    <?php 
    } 
    ?>
</sitemapindex>