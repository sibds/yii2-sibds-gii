<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
$nameModule = $generator->generateString(' {modelClass}: ', ['modelClass' => Inflector::camel2words(StringHelper::basename($generator->modelClass))]);
?>

use kartik\alert\Alert;
use \<?=$generator->getNamespace()?>Module;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = ($model->isNewRecord?<?= $generator->generateString('Create') ?>.<?=$nameModule?>:<?= $generator->generateString('Update') ?>.<?=$nameModule?>) . ' ' . $model-><?= $generator->getNameAttribute() ?>;
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['list']];
if(!$model->isNewRecord)
    $this->params['breadcrumbs'][] = ['label' => $model-><?= $generator->getNameAttribute() ?>, 'url' => ['update', <?= $urlParams ?>]];
$this->params['breadcrumbs'][] = ($model->isNewRecord?<?= $generator->generateString('Create') ?>:<?= $generator->generateString('Update') ?>);
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-update">

    <?= "<?php " ?>
    if(\Yii::$app->session->hasFlash('update-success'))
        echo Alert::widget([
            'type' => Alert::TYPE_SUCCESS,
            'title' => 'Saved',
            'icon' => 'glyphicon glyphicon-ok-sign',
            'body' => Module::t('form', Yii::$app->session->getFlash('update-success')),
            'showSeparator' => true,
            'delay' => 2000
        ]); ?>

    <?= "<?= " ?>$this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
