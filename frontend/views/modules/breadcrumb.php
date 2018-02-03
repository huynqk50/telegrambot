<div class="container" id="breadcrumb">
    <div class="wrap">
        <ol>
            <?php
            foreach ($this->context->breadcrumbs as $item) {
                echo "<li><a href=\"{$item['url']}\" title=\"{$item['label']}\">{$item['label']}</a></li>";
            }
            ?>
        </ol>
    </div>
</div>