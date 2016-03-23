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
echo "<?php\n";
?>

namespace <?= $ns ?>;

use Yii;

/**
* <?= $generator->moduleID ?> module definition class
*/
class <?= $className ?> extends \yii\base\Module
{
    /**
    * @inheritdoc
    */
    public $controllerNamespace = '<?= $generator->getControllerNamespace() ?>';

    public $defaultRoute = '<?= $generator->moduleID ?>/list';

    /**
    * @inheritdoc
    */
    public function init()
    {
        parent::init();
        $this->registerTranslations();
    }

    public function registerTranslations()
    {
        Yii::$app->i18n->translations['modules/<?= $generator->moduleID ?>/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'ru-RU',
            'basePath' => '@app/modules/<?= $generator->moduleID ?>/messages',
            'fileMap' => [
                'modules/<?= $generator->moduleID ?>/<?= $generator->moduleID ?>' => '<?= $generator->moduleID ?>.php',
                'modules/<?= $generator->moduleID ?>/form' => 'form.php',
            ],
        ];
    }

    public static function t($category, $message, $params = [], $language = null)
    {
        if(!array_key_exists('modules/<?= $generator->moduleID ?>/*', Yii::$app->i18n->translations))
        {
            Yii::$app->i18n->translations['modules/<?= $generator->moduleID ?>/*'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'ru-RU',
                'basePath' => '@app/modules/<?= $generator->moduleID ?>/messages',
                'fileMap' => [
                    'modules/<?= $generator->moduleID ?>/<?= $generator->moduleID ?>' => '<?= $generator->moduleID ?>.php',
                    'modules/<?= $generator->moduleID ?>/form' => 'form.php',
                ],
            ];
        }

        return Yii::t('modules/<?= $generator->moduleID ?>/' . $category, $message, $params, $language);
    }

}
