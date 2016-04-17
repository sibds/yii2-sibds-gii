<?php
/**
 * Created by PhpStorm.
 * User: vadim
 * Date: 17.04.16
 * Time: 18:03
 */
/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\module\Generator */
$className = $generator->moduleClass;
$pos = strrpos($className, '\\');
$ns = ltrim(substr($className, 0, $pos), '\\');
$className = substr($className, $pos + 1);
$moduleId = $generator->moduleID;
echo "<?php\n";
?>
return [
    ['label' => '<?=$className?>', 'url' => ['/<?=$moduleId?>/<?=$moduleId?>/list'], 'icon' => 'fa fa-circle-o'],
];
