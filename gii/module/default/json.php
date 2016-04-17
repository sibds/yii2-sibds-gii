<?php
/**
 * This is the template for generating a module class file.
 */
/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\module\Generator */
$className = $generator->moduleClass;
$pos = strrpos($className, '\\');
$ns = ltrim(substr($className, 0, $pos), '\\');
$className = substr($className, $pos + 1);
?>
{
    "name": "<?= $className ?>",
    "alias": "<?= $generator->moduleID ?>"
}
