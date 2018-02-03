<?php

namespace frontend\controllers;

use frontend\models\Product;
use frontend\models\ProductAttributeGroup;
use frontend\models\ProductCategory;
use frontend\models\Redirect;
use frontend\models\UrlParam;
use Yii;
use yii\helpers\Url;
use frontend\models\ProductSearch;
use yii\helpers\VarDumper;

class ProductController extends BaseController
{
    const ITEMS_PER_PAGE = 16;
    const PAGE_KEY = 'Product.page';
    const SORT_KEY = 'Product.sort';
    const ATTRIBUTES_KEY = 'Product.attributes';

    public function actionIndex()
    {
        $slug = Yii::$app->request->get(UrlParam::SLUG, '');

        if (!($model = Product::findOneBySlug($slug))) {
            Redirect::go();
            return;
        }

        $this->link_canonical = $model->getLink();

        if (!Redirect::compareUrl($this->link_canonical)) {
            $this->redirect($this->link_canonical);
        }

        $related_items = $model->getRelatedProducts()->orderBy('published_at DESC')->all();

        if ($category = $model->findCategory()) {
            if ($parent_category = $category->findParent()) {
                $this->breadcrumbs[] = ['label' => $parent_category->name,
                    'url' => $parent_category->getLink()];
            }
            $this->breadcrumbs[] = ['label' => $category->name,
                'url' => $category->getLink()];
        }
        $this->breadcrumbs[] = ['label' => $model->name, 'url' => $this->link_canonical];

        if (!$this->seo_exist) {
            $this->page_title = $model->page_title;
            $this->h1 = $model->h1;
            $this->meta_title = $model->meta_title;
            $this->meta_description = $model->meta_description;
            $this->meta_keywords = $model->meta_keywords;
            $this->long_description = $model->long_description;
            $this->meta_image = $model->getBanner();
        }

        // @TODO: Gets product options and groups them by product option groups
        $option_groups = [];
        foreach ($model->getProductCustomizations()->with('productCustomizationToOptions')->orderBy('sort_order asc')->all() as $customization) {
            foreach ($customization->getProductOptions()->with('group')->orderBy('sort_order asc')->all() as $option) {
                if (!($group = $option->group)) {
                    continue;
                }
                $option_groups[$group->id]['model'] = $group->attributes;
                $option_groups[$group->id]['options'][$option->id]['model'] = $option->attributes;
                $option_groups[$group->id]['options'][$option->id]['customizations'][$customization->id]['model'] = $customization->attributes;
                $option_groups[$group->id]['options'][$option->id]['customizations'][$customization->id]['stock_available'] = $customization->isStockAvailable();
                foreach ($customization->getProductImages()->orderBy('sort_order asc')->all() as $image) {
                    $option_groups[$group->id]['options'][$option->id]['customizations'][$customization->id]['images'][$image->id]['model'] = $image;
                    $option_groups[$group->id]['options'][$option->id]['customizations'][$customization->id]['images'][$image->id]['source'] = $image->getImage();
                }
            }
        }

        $model->updateCounters(['view_count' => 1]);

        return $this->render('index', [
            'model' => $model,
            'option_groups' => $option_groups,
            'related_items' => $related_items,
        ]);
    }

    public function actionViewAll()
    {
        $this->link_canonical = Url::to(['view-all'], true);
        $this->breadcrumbs[] = ['label' => 'Sản phẩm', 'url' => $this->link_canonical];

//        $page = Yii::$app->request->get('page', 0);
//        if (!is_numeric($page) || $page == 1 || $page < 0) {
//            $this->redirect($this->link_canonical, 301);
//        }
//        if ($page > 1) {
//            $this->meta_index = 'noindex';
//            $this->meta_follow = 'nofollow';
//            $this->page_title .= " - trang $page";
//            $this->meta_keywords .= " - trang $page";
//            $this->meta_description .= " - trang $page";
//        } else {
//            $page = 1;
//        }
//        $models = Product::find()
//                ->limit(static::ITEMS_PER_PAGE + 1)
//                ->offset(($page - 1) * static::ITEMS_PER_PAGE)
//                ->orderBy('published_at desc')
//                ->allPublished();
//        if ($page > 1 && !isset($models[0])) {
//            $this->redirect($this->link_canonical, 301);
//        }

//        $totalItems = Product::find()
//                ->countPublished();
//
//        $total = ceil($totalItems / static::ITEMS_PER_PAGE);
//        $firstItemOnPage = $totalItems > 0
//                ? ($page-1) * static::ITEMS_PER_PAGE + 1 : 0;
//        $lastItemOnPage = $totalItems < $page * static::ITEMS_PER_PAGE
//                ? $totalItems : $page * static::ITEMS_PER_PAGE;
//        $pagination = [
//            'firstItemOnPage' => $firstItemOnPage,
//            'lastItemOnPage' => $lastItemOnPage,
//            'totalItems' => $totalItems,
//            'current' => $page,
//            'total' => $total,
//        ];

        $product_cats = array_values(ProductCategory::indexData());

        return $this->render('viewAll', [
//            'title' => 'Sản phẩm',
//            'models' => $models,
//            'page' => $page,
            'product_cats' => $product_cats
        ]);
    }

    /*
    public function actionCategory()
    {
        $slug = Yii::$app->request->get(UrlParam::SLUG);
        if (!($category = ProductCategory::findOneBySlug($slug))) {
            Redirect::go();
        }

        $this->link_canonical = $category->getLink();
        if (!Redirect::compareUrl($this->link_canonical)) {
            $this->redirect($this->link_canonical, 301);
        }
        if ($parent_category = $category->findParent()) {
            $this->breadcrumbs[] = ['label' => $parent_category->name,
                'url' => $parent_category->getLink()];
        }
        $this->breadcrumbs[] = ['label' => $category->name,
            'url' => $this->link_canonical];

        if (!$this->seo_exist) {
            $this->page_title = $category->page_title;
            $this->h1 = $category->h1;
            $this->meta_title = $category->meta_title;
            $this->meta_description = $category->meta_description;
            $this->meta_keywords = $category->meta_keywords;
            $this->long_description = $category->long_description;
            $this->meta_image = $category->getImage();
        }

//        $page = Yii::$app->request->get('page', 0);
//        if (!is_numeric($page) || $page == 1 || $page < 0) {
//            $this->redirect($this->link_canonical, 301);
//        }
//        if ($page > 1) {
//            $this->meta_index = 'noindex';
//            $this->meta_follow = 'nofollow';
//            $this->page_title .= " - trang $page";
//            $this->meta_keywords .= " - trang $page";
//            $this->meta_description .= " - trang $page";
//        } else {
//            $page = 1;
//        }

        $page = 1;

        $models = $category->getAllProducts()
            ->limit(static::ITEMS_PER_PAGE + 1)
            ->offset(($page - 1) * static::ITEMS_PER_PAGE)
            ->orderBy('published_at desc')
            ->allPublished();

        Yii::$app->session->set(self::PAGE_KEY, $page + 1);

//        if ($page > 1 && !isset($models[0])) {
//            $this->redirect($this->link_canonical, 301);
//        }

//        $totalItems = $category->getAllProducts()
//                ->countPublished();
//
//        $total = ceil($totalItems / static::ITEMS_PER_PAGE);
//        $firstItemOnPage = $totalItems > 0
//                ? ($page-1) * static::ITEMS_PER_PAGE + 1 : 0;
//        $lastItemOnPage = $totalItems < $page * static::ITEMS_PER_PAGE
//                ? $totalItems : $page * static::ITEMS_PER_PAGE;
//        $pagination = [
//            'firstItemOnPage' => $firstItemOnPage,
//            'lastItemOnPage' => $lastItemOnPage,
//            'totalItems' => $totalItems,
//            'current' => $page,
//            'total' => $total,
//        ];

        return $this->render('category', [
            'title' => $category->label,
            'models' => array_slice($models, 0, self::ITEMS_PER_PAGE),
            'has_more' => isset($models[static::ITEMS_PER_PAGE]),
            'category_id' => $category->id,
        ]);

    }
    */

    public function actionCategory()
    {
        $slug = Yii::$app->request->get(UrlParam::SLUG);
        if (!($category = ProductCategory::findOneBySlug($slug))) {
            Redirect::go();
        }

        $this->link_canonical = $category->getLink();
        if (!Redirect::compareUrl($this->link_canonical)) {
            $this->redirect($this->link_canonical, 301);
        }
        if ($parent_category = $category->findParent()) {
            $this->breadcrumbs[] = ['label' => $parent_category->name,
                'url' => $parent_category->getLink()];
        }
        $this->breadcrumbs[] = ['label' => $category->name,
            'url' => $this->link_canonical];

        if (!$this->seo_exist) {
            $this->page_title = $category->page_title;
            $this->h1 = $category->h1;
            $this->meta_title = $category->meta_title;
            $this->meta_description = $category->meta_description;
            $this->meta_keywords = $category->meta_keywords;
            $this->long_description = $category->long_description;
            $this->meta_image = $category->getImage();
        }

        $page = 1;
        Yii::$app->session->set(self::PAGE_KEY, $page + 1);

        $product_sort = [
            'sort' => [
                'label' => 'Sắp xếp theo',
                'data' => [
                    'price-desc' => [
                        'label' => 'Giá cao đến thấp',
                        'statement' => 'price DESC, original_price DESC',
                        'checked' => false,
                    ],
                    'price-asc' => [
                        'label' => 'Giá thấp đến cao',
                        'statement' => 'price ASC, original_price ASC',
                        'checked' => false,
                    ],
                    'time-desc' => [
                        'label' => 'Sản phẩm gần đây',
                        'statement' => 'published_at DESC, created_at DESC',
                        'checked' => true,
                    ],
                ],
            ],
        ];

        $product_attribute_filter = [];
        foreach (ProductAttributeGroup::find()->orderBy('sort_order asc')->all() as $attribute_group) {
            foreach ($attribute_group->getProductAttributes()->orderBy('sort_order asc')->all() as $attribute) {
                $product_attribute_filter[$attribute_group->id]['label'] = $attribute_group->name;
                $product_attribute_filter[$attribute_group->id]['data'][$attribute->id] = [
                    'label' => $attribute->name,
                    'checked' => false,
                ];
            }
        }

        $product_attributes = [];

        if (Yii::$app->request->isPost) {
            $form_product_sort = Yii::$app->request->post('product-sort');
            if ($form_product_sort != null) {
                foreach ($product_sort as $key => &$item) {
                    foreach ($item['data'] as $name => $value) {
                        $item['data'][$name]['checked'] = false;
                    }
                }
                foreach ($form_product_sort as $name => $value) {
                    if (!isset($product_sort[$name]) || !isset($product_sort[$name]['data'][$value])) {
                        break;
                    }
                    foreach ($product_sort[$name]['data'] as $val) {
                        $val['checked'] = false;
                    }
                    $product_sort[$name]['data'][$value]['checked'] = true;
                }
            }

            $form_product_attributes = Yii::$app->request->post('product-attribute-group');
            if ($form_product_attributes != null) {
                foreach ($form_product_attributes as $group_id => $attribute_ids) {
                    foreach ($attribute_ids as $attribute_id) {
                        $product_attribute_filter[$group_id]['data'][$attribute_id]['checked'] = true;
                        $product_attributes[$group_id][] = $attribute_id;
                    }
                }
            }
        }

        $sort_statement = '';
        $i = 0;
        foreach ($product_sort as $key => $item) {
            foreach ($item['data'] as $name => $value) {
                if ($value['checked']) {
                    if ($i++ > 0) {
                        $sort_statement .= ', ';
                    }
                    $sort_statement .= $value['statement'];
                }
            }
        }

        Yii::$app->session->set(self::SORT_KEY, $sort_statement);
        Yii::$app->session->set(self::ATTRIBUTES_KEY, $product_attributes);

        $query = $category->getAllProducts()
            ->limit(static::ITEMS_PER_PAGE + 1)
            ->offset(($page - 1) * static::ITEMS_PER_PAGE)
            ->orderBy($sort_statement);

        $i = 0;
        foreach ($product_attributes as $group_id => $attribute_ids) {
            $i++;
            $query->innerJoinWith(['productToAttributes' =>
                function ($query) use ($attribute_ids, $i) {
                    $query->from("product_to_attribute ref$i")
                        ->andWhere(['in', "ref$i.attribute_id", $attribute_ids]);
                }
            ]);
        }

        $models = $query->allPublished();

        return $this->render('category', [
            'title' => $category->label ? $category->label : $category->name,
            'models' => array_slice($models, 0, self::ITEMS_PER_PAGE),
            'has_more' => isset($models[static::ITEMS_PER_PAGE]),
            'category_id' => $category->id,
            'product_sort' => $product_sort,
            'product_attribute_filter' => $product_attribute_filter
        ]);

    }

    public function actionAjaxGetItems()
    {
        $this->layout = false;

        $cat_id = Yii::$app->request->getBodyParam(UrlParam::CATEGORY_ID, 0);
        $category = ProductCategory::find()->where(['id' => $cat_id])->oneActive();
        $query = $category ? $category->getAllProducts() : Product::find();

        $page = Yii::$app->session->get(self::PAGE_KEY, 2);
        Yii::$app->session->set(self::PAGE_KEY, $page + 1);

        $sort_statement = Yii::$app->session->get(self::SORT_KEY, 'published_at DESC');
        $product_attributes = Yii::$app->session->get(self::ATTRIBUTES_KEY, []);

        $query->limit(static::ITEMS_PER_PAGE + 1)
            ->offset(($page - 1) * static::ITEMS_PER_PAGE)
            ->orderBy($sort_statement);

        $i = 0;
        foreach ($product_attributes as $group_id => $attribute_ids) {
            $i++;
            $query->innerJoinWith(['productToAttributes' =>
                function ($query) use ($attribute_ids, $i) {
                    $query->from("product_to_attribute ref$i")
                        ->andWhere(['in', "ref$i.attribute_id", $attribute_ids]);
                }
            ]);
        }

        $models = $query->allPublished();

        return json_encode([
            'content' => $this->render('items', ['models' => array_slice($models, 0, self::ITEMS_PER_PAGE)]),
            'has_more' => isset($models[static::ITEMS_PER_PAGE])
        ]);
    }

    public function actionCounter()
    {
        $model = Product::findOne(Yii::$app->request->post('id'));
        if ($model) {
            $comment_count = Yii::$app->request->post('comment_count');
            $like_count = Yii::$app->request->post('like_count');
            $share_count = Yii::$app->request->post('share_count');
            $check = false;
            if (!empty($comment_count)) {
                $model->comment_count = $comment_count;
                $check = true;
            }
            if (!empty($like_count)) {
                $model->like_count = $like_count;
                $check = true;
            }
            if (!empty($share_count)) {
                $model->share_count = $share_count;
                $check = true;
            }
            if ($check) {
                $model->save();
            }
        }
        return;
    }

}
