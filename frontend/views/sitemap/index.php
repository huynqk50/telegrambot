<?= '<?xml version="1.0" encoding="UTF-8"?>' ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
    <url>
        <loc><?= $home['url'] ?></loc>
        <lastmod><?= date('c', time()) ?></lastmod>
        <changefreq>always</changefreq>
        <priority>1.0</priority>
    </url>
<?php
if (isset($parent) && $parent !== null) {
?>
    <url>
        <loc><?= $parent['url'] ?></loc>
        <?php
        if ($parent['img'] !== '') {
        ?>
        <image:image>
            <image:loc><?= $parent['img'] ?></image:loc>
        </image:image>
        <?php
        }
        ?>
        <lastmod><?= date('c', time()) ?></lastmod>
        <changefreq>always</changefreq>
        <priority>1.0</priority>
    </url>
<?php
}
?>
<?php
if (isset($category) && $category !== null) {
?>
    <url>
        <loc><?= $category['url'] ?></loc>
        <?php
        if ($category['img'] !== '') {
        ?>
        <image:image>
            <image:loc><?= $category['img'] ?></image:loc>
        </image:image>
        <?php
        }
        ?>
        <lastmod><?= date('c', time()) ?></lastmod>
        <changefreq>always</changefreq>
        <priority>1.0</priority>
    </url>
<?php
}
?>
<?php
foreach ($children as $item) {
?>
    <url>
        <loc><?= $item['url'] ?></loc>
        <?php
        if ($item['img'] !== '') {
        ?>
        <image:image>
            <image:loc><?= $item['img'] ?></image:loc>
        </image:image>
        <?php
        }
        ?>
        <lastmod><?= date('c', time()) ?></lastmod>
        <changefreq>always</changefreq>
        <priority>1.0</priority>
    </url>
<?php
}
?>
<?php
foreach ($items as $item) {
?>
    <url>
        <loc><?= $item['url'] ?></loc>
        <?php
        foreach ($item['imgs'] as $img) {
        ?>
        <image:image>
            <image:loc><?= $img ?></image:loc>
        </image:image>
        <?php
        }
        ?>
        <lastmod><?= date('c', time()) ?></lastmod>
        <changefreq>always</changefreq>
        <priority>0.9</priority>
    </url>
<?php
}
?>
</urlset>