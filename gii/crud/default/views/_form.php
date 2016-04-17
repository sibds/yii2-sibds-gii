<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form">

    <?= "<?php " ?>$form = ActiveForm::begin(); ?>
    
    <?= "<?php " ?>
    if($model->hasErrors()){
        echo $form->errorSummary($model);
    }
    ?>

    <?php foreach ($generator->getColumnNames() as $attribute) {
        if(in_array($attribute, ['created_at', 'created_by', 'updated_at', 'updated_by',
        'tree', 'lft', 'rgt', 'depth', 'order']))
            continue;

        if (in_array($attribute, $safeAttributes)) {
            echo "    <?= " . $generator->generateActiveField($attribute) . " ?>\n\n";
        }
    } ?>

    <?= "<?= " ?> \sibds\form\FormFooter::widget(['model'=>$model]); ?>

    <?= "<?php " ?>ActiveForm::end(); ?>

</div>
