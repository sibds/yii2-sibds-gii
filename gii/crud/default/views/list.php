<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

echo "<?php\n";
?>

use yii\helpers\Html;
use <?= !$generator->testNestedSet() ? "sibds\\grid\\GridView" : "sibds\\widgets\\Nestable" ?>;
<?= $generator->enablePjax ? 'use yii\widgets\Pjax;' : '' ?>

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index">

    <h1><?= "<?= " ?>Html::encode($this->title) ?></h1>
    <?php if(!empty($generator->searchModelClass)): ?>
        <?= "    <?php " . ($generator->indexWidgetType === 'grid' ? "// " : "") ?>echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php endif; ?>

    <p>
        <?= "<?= " ?>Html::a(<?= $generator->generateString('Create ' . Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>, ['update'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= $generator->enablePjax ? '<?php Pjax::begin([\'id\'=>"'.Inflector::camel2id(StringHelper::basename($generator->modelClass)).'"]); ?>' : '' ?>
    <?php if (!$generator->testNestedSet()): ?>
        <?= "<?= " ?>GridView::widget([
        'dataProvider' => $dataProvider,
        <?= !empty($generator->searchModelClass) ? "'filterModel' => \$searchModel,\n        'columns' => [\n" : "'columns' => [\n"; ?>

        <?php
        $count = 0;
        if (($tableSchema = $generator->getTableSchema()) === false) {
            foreach ($generator->getColumnNames() as $name) {
                if (++$count < 6) {
                    echo "            '" . $name . "',\n";
                } else {
                    echo "            /* '" . $name . "'*/,\n";
                }
            }
        } else {
            foreach ($tableSchema->columns as $column) {
                $format = $generator->generateColumnFormat($column);
                if (++$count < 6) {
                    if($column->name==='id'){
                        echo "
           [
               'class' => 'sibds\\grid\\UrlColumn',
               'attribute'=>'" . $column->name . "',
               'width' => '50px',
               'hAlign' => 'center',
           ],\n";
                    }elseif ($column->type === 'text') {
                        if(preg_match('/^(name|label|caption|subject)$/i', $column->name)){
                            echo "
               [
                   'class' => 'sibds\\grid\\UrlColumn',
                   'attribute'=>'" . $column->name ."',
                   'showLock' => true,
               ],\n";
                        }else{
                            echo "
               [
                   'class' => 'sibds\\grid\\UrlColumn',
                   'attribute'=>'" . $column->name ."',
               ],\n";
                        }
                    }elseif (preg_match('/^(created_at|updated_at)$/i', $column->name) && $column->type === 'integer') {
                        echo "
               [
                   'attribute'=>'" . $column->name ."',
                   'format'=>['date', 'dd.MM.YYYY HH:mm'],
               ],\n";
                    }else{
                        echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
                    }
                } else {
                    echo "            // '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
                }
            }
        }
        ?>

        ['class' => 'sibds\grid\ActionColumn'],
        ],
        ]); ?>
    <?php else: ?>
        <?= "<?= " ?> Nestable::widget([
            'autoQuery' => <?= $generator->modelClass ?>::find()
        ])
        ?>
    <?php endif; ?>
    <?= $generator->enablePjax ? '<?php Pjax::end(); ?>' : '' ?>
</div>
