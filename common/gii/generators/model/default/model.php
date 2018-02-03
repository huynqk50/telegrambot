<?php

use yii\db\TableSchema;
use common\gii\generators\model\Generator;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;
use yii\web\View;
/**
 * This is the template for generating the model class of a specified table.
 */

/* @var $this View */
/* @var $generator Generator */
/* @var $tableName string full table name */
/* @var $className string class name */
/* @var $queryClassName string query class name */
/* @var $tableSchema TableSchema */
/* @var $labels string[] list of attribute labels (name => label) */
/* @var $rules string[] list of validation rules */
/* @var $relations array list of relations (name => relation declaration) */

echo "<?php\n";
?>

namespace <?= $generator->ns ?>;

use common\utils\FileUtils;
use common\utils\Dump;
use yii\helpers\Html;
use Yii;

/**
 * This is the model class for table "<?= $generator->generateTableName($tableName) ?>".
 *
<?php $modelClass = StringHelper::basename($generator->modelClass); ?>
<?php foreach ($tableSchema->columns as $column): ?>
 * @property <?= "{$column->phpType} \${$column->name}\n" ?>
<?php endforeach; ?>
<?php if (!empty($relations)): ?>
 *
<?php foreach ($relations as $name => $relation): ?>
 * @property <?= $relation[1] . ($relation[2] ? '[]' : '') . ' $' . lcfirst($name) . "\n" ?>
<?php endforeach; ?>
<?php endif; ?>
 */
class <?= $className ?> extends <?= '\\' . ltrim($generator->baseClass, '\\') . "\n" ?>
{
<?php
if(isset($tableSchema->columns['slug'])) { ?>
    
    /**
    * function ->getLink ()
    */
    public $_link;
    public function getLink ()
    {
        if ($this->_link === null) {
            $this->_link = Yii::$app->params['frontend_url']
                . Yii::$app->frontendUrlManager->createUrl(['<?= Inflector::camel2id($modelClass) ?>/index', 'slug' => $this->slug]);
        }
        return $this->_link;
    }
<?php } ?>

    /**
    * function ::create ($data)
    */
    public static function create ($data)
    {
        $now = strtotime('now');
        $username = Yii::$app->user->identity->username;  
        $model = new <?= $modelClass ?>();
        if($model->load($data)) {
            if ($log = new UserLog()) {
                $log->username = $username;
                $log->action = 'Create';
                $log->object_class = '<?= $modelClass ?>';
                $log->created_at = $now;
                $log->is_success = 0;
                $log->save();
            }
<?php foreach ($tableSchema->columns as $column) {
    if (strpos(strrev($column->name), 'ta_') === 0) {
        if ($column->name === 'created_at') {
            echo "            \$model->$column->name = \$now;\n";
        }elseif ($column->name !== 'updated_at') {
            echo "            \$model->$column->name = strtotime(\$model->$column->name);\n";
        }
    } elseif ($column->name === 'created_by') {
        echo "            \$model->$column->name = \$username;\n";
    }
} ?>
<?php 
if (isset($tableSchema->columns['image_path'])) { ?>                
            $model->image_path = FileUtils::generatePath($now, Yii::$app->params['images_folder']);

            $targetFolder = Yii::$app->params['images_folder'] . $model->image_path;
            $targetUrl = Yii::$app->params['images_url'] . $model->image_path;
            
<?php foreach($tableSchema->columns as $column) { ?>
<?php if(preg_match('/^(image|avatar|banner)$/i', $column->name)) { ?>
            if (!empty($data[Html::getInputId($model, '<?= $column->name ?>')])) {
                $copyResult = FileUtils::copyImage([
                    'imageName' => $model-><?= $column->name ?>,
                    'fromFolder' => Yii::$app->params['uploads_folder'],
                    'toFolder' => $targetFolder,
                    'resize' => array_values(self::$<?= $column->name ?>_resizes),
                    'removeInputImage' => true,
                ]);
                if ($copyResult['success']) {
                    $model-><?= $column->name ?> = $copyResult['imageName'];
                }
            }
<?php }} ?>
<?php foreach ($tableSchema->columns as $column) {
if ($column->type === 'text') { ?>                    
            $model-><?= $column->name ?> = FileUtils::copyContentImages([
                'content' => $model-><?= $column->name ?>,
                'defaultFromFolder' => Yii::$app->params['uploads_folder'],
                'toFolder' => $targetFolder,
                'toUrl' => $targetUrl,
                'removeInputImage' => true,
            ]);
<?php } ?>
<?php } ?>
<?php } ?>
            if ($model->save()) {
                if ($log) {
                    $log->object_pk = $model->id;
                    $log->is_success = 1;
                    $log->save();
                }
                return $model;
            }
            Dump::errors($model->errors);
            return;
        }
        return false;
    }
    
    /**
    * function ->update2 ($data)
    */
    public function update2 ($data)
    {
        $now = strtotime('now');
        $username = Yii::$app->user->identity->username;   
        if ($this->load($data)) {
            if ($log = new UserLog()) {
                $log->username = $username;
                $log->action = 'Update';
                $log->object_class = '<?= $modelClass ?>';
                $log->object_pk = $this->id;
                $log->created_at = $now;
                $log->is_success = 0;
                $log->save();
            }
<?php foreach ($tableSchema->columns as $column) {
    if (strpos(strrev($column->name), 'ta_') === 0) {
        if ($column->name === 'updated_at') {
            echo "            \$this->$column->name = \$now;\n";
        }elseif ($column->name !== 'created_at') {
            echo "            \$this->$column->name = strtotime(\$this->$column->name);\n";
        }
    } elseif ($column->name === 'updated_by') {
        echo "            \$this->$column->name = \$username;\n";
    }
} ?>
<?php
if (!empty($tableSchema->columns['slug']) && isset($tableSchema->columns['old_slugs'])) { ?>
            if ($this->slug != $this->getOldAttribute('slug')) {
                $old_slugs_arr = json_decode($this->old_slugs, true);
                is_array($old_slugs_arr) or $old_slugs_arr = array();
                $old_slugs_arr[$now] = $this->getOldAttribute('slug');
                $this->old_slugs = json_encode($old_slugs_arr);
            }
<?php } ?>
<?php 
if (isset($tableSchema->columns['image_path'])) { ?>                  
            if ($this->image_path == null || trim($this->image_path) == '' || !is_dir(Yii::$app->params['images_folder'] . $this->image_path)) {
                $this->image_path = FileUtils::generatePath($now, Yii::$app->params['images_folder']);
            }
            
            $targetFolder = Yii::$app->params['images_folder'] . $this->image_path;
            $targetUrl = Yii::$app->params['images_url'] . $this->image_path;
            
<?php foreach($tableSchema->columns as $column) { ?>
<?php if(preg_match('/^(image|avatar|banner)$/i', $column->name)) { ?>
            if (!empty($data[Html::getInputId($this, '<?= $column->name ?>')])) {
                $copyResult = FileUtils::updateImage([
                    'imageName' => $this-><?= $column->name ?>,
                    'oldImageName' => $this->getOldAttribute('<?= $column->name ?>'),
                    'fromFolder' => Yii::$app->params['uploads_folder'],
                    'toFolder' => $targetFolder,
                    'resize' => array_values(self::$<?= $column->name ?>_resizes),
                    'removeInputImage' => true,
                ]);
                if ($copyResult['success']) {
                    $this-><?= $column->name ?> = $copyResult['imageName'];
                }
            }
<?php }} ?>
<?php foreach ($tableSchema->columns as $column) { 
if ($column->type === 'text') { ?>
            $this-><?= $column->name ?> = FileUtils::updateContentImages([
                'content' => $this-><?= $column->name ?>,
                'oldContent' => $this->getOldAttribute('<?= $column->name ?>'),
                'defaultFromFolder' => Yii::$app->params['uploads_folder'],
                'toFolder' => $targetFolder,
                'toUrl' => $targetUrl,
                'removeInputImage' => true,
            ]);
<?php }} ?>
<?php } ?>            
            if ($this->save()) {
                if ($log) {
                    $log->is_success = 1;
                    $log->save();
                }
                return $this;
            }
        }
        return false;
    }
    
    /**
    * function ->delete ()
    */
    public function delete ()
    {
        $now = strtotime('now');
        $username = Yii::$app->user->identity->username;    
        if ($log = new UserLog()) {
            $log->username = $username;
            $log->action = 'Delete';
            $log->object_class = '<?= $modelClass ?>';
            $log->object_pk = $this->id;
            $log->created_at = $now;
            $log->is_success = 0;
            $log->save();
        }
        if(parent::delete()) {
            if ($log) {
                $log->is_success = 1;
                $log->save();
            }
<?php if(isset($tableSchema->columns['image_path'])) { ?>
            if ($this->image_path != '') {
                $targetFolder = Yii::$app->params['images_folder'] . $this->image_path;
                $targetUrl = Yii::$app->params['images_url'] . $this->image_path;
            
<?php foreach($tableSchema->columns as $column) { ?>
<?php if(preg_match('/^(image|avatar|banner)$/i', $column->name)) { ?>
                FileUtils::updateImage([
                    'imageName' => '',
                    'oldImageName' => $this-><?= $column->name ?>,
                    'fromFolder' => Yii::$app->params['uploads_folder'],
                    'toFolder' => $targetFolder,
                    'resize' => array_values(self::$<?= $column->name ?>_resizes),
                ]);
                
<?php }} ?>
<?php foreach ($tableSchema->columns as $column) { 
if ($column->type === 'text') { ?>
                FileUtils::updateContentImages([
                    'content' => '',
                    'oldContent' => $this-><?= $column->name ?>,
                    'defaultFromFolder' => Yii::$app->params['uploads_folder'],
                    'toFolder' => $targetFolder,
                    'toUrl' => $targetUrl,
                ]);
                
<?php }} ?>
            }
<?php } ?>
            return true;
        }
        return false;
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '<?= $generator->generateTableName($tableName) ?>';
    }
<?php if ($generator->db !== 'db'): ?>

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('<?= $generator->db ?>');
    }
<?php endif; ?>

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [<?= "\n            " . implode(",\n            ", $rules) . "\n        " ?>];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
<?php foreach ($labels as $name => $label): ?>
            <?= "'$name' => " . $generator->generateString($label) . ",\n" ?>
<?php endforeach; ?>
        ];
    }
<?php foreach ($relations as $name => $relation): ?>

    /**
     * @return \yii\db\ActiveQuery
     */
    public function get<?= $name ?>()
    {
        <?= $relation[0] . "\n" ?>
    }
<?php endforeach; ?>
<?php if ($queryClassName): ?>
<?php
    $queryClassFullName = ($generator->ns === $generator->queryNs) ? $queryClassName : '\\' . $generator->queryNs . '\\' . $queryClassName;
    echo "\n";
?>
    /**
     * @inheritdoc
     * @return <?= $queryClassFullName ?> the active query used by this AR class.
     */
    public static function find()
    {
        return new <?= $queryClassFullName ?>(get_called_class());
    }
<?php endif; ?>
}
