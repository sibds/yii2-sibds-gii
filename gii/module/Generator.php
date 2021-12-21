<?php
/**
 * Created by PhpStorm.
 * User: vadim
 * Date: 09.03.16
 * Time: 15:33
 */

namespace sibds\gii\module;

use \Yii;
use yii\gii\CodeFile;
use yii\helpers\StringHelper;
use yii\bootstrap\Html;
use yii\rest\Controller;

class Generator extends \yii\gii\Generator
{
    public $moduleClass;
    public $moduleID;

    public function getName()
    {
        return 'SibDS Module Generator';
    }

    public function getDescription()
    {
        return 'SibDS module generator.';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['moduleID', 'moduleClass'], 'filter', 'filter' => 'trim'],
            [['moduleID', 'moduleClass'], 'required'],
            [['moduleID'], 'match', 'pattern' => '/^[\w\\-]+$/', 'message' => 'Only word characters and dashes are allowed.'],
            [['moduleClass'], 'match', 'pattern' => '/^[\w\\\\]*$/', 'message' => 'Only word characters and backslashes are allowed.'],
            [['moduleClass'], 'validateModuleClass'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'moduleID' => 'Module ID',
            'moduleClass' => 'Module Class',
        ];
    }
    /**
     * @inheritdoc
     */
    public function hints()
    {
        return [
            'moduleID' => 'This refers to the ID of the module, e.g., <code>admin</code>.',
            'moduleClass' => 'This is the fully qualified class name of the module, e.g., <code>app\modules\admin\Module</code>.',
        ];
    }
    /**
     * @inheritdoc
     */
    public function successMessage()
    {
        if (Yii::$app->hasModule($this->moduleID)) {
            $link = Html::a('try it now', Yii::$app->getUrlManager()->createUrl($this->moduleID), ['target' => '_blank']);
            return "The module has been generated successfully. You may $link.";
        }
        $output = <<<EOD
<p>The module has been generated successfully.</p>
<p>To access the module, you need to add this to your application configuration:</p>
EOD;
        $code = <<<EOD
<?php
    ......
    'modules' => [
        '{$this->moduleID}' => [
            'class' => '{$this->moduleClass}',
        ],
    ],
    ......
EOD;
        return $output . '<pre>' . highlight_string($code, true) . '</pre>';
    }
    /**
     * @inheritdoc
     */
    public function requiredTemplates()
    {
        return ['module.php', 'controller.php', 'view.php', 'json.php', 'menu.php', 'message.php'];
    }
    /**
     * @inheritdoc
     */
    public function generate()
    {
        $files = [];
        $modulePath = $this->getModulePath();
        $files[] = new CodeFile(
            $modulePath.'/module.json',
            $this->render("json.php")
        );
        $files[] = new CodeFile(
            $modulePath . '/messages/ru/' . $this->moduleID . '.php',
            $this->render('message.php')
        );
        $files[] = new CodeFile(
            $modulePath . '/messages/ru/form.php',
            $this->render('form.php')
        );
        $files[] = new CodeFile(
            $modulePath . '/messages/en/form.php',
            $this->render('message.php')
        );
        $files[] = new CodeFile(
            $modulePath . '/messages/en/' . $this->moduleID . '.php',
            $this->render('message.php')
        );
        $files[] = new CodeFile(
            $modulePath . '/' . StringHelper::basename($this->moduleClass) . '.php',
            $this->render("module.php")
        );
        $files[] = new CodeFile(
            $modulePath . '/controllers/DefaultController.php',
            $this->render("controller.php")
        );
        $files[] = new CodeFile(
            $modulePath . '/views/default/index.php',
            $this->render("view.php")
        );
        $files[] = new CodeFile(
            $modulePath . '/views/_menu.php',
            $this->render('menu.php')
        );
        return $files;
    }
    /**
     * Validates [[moduleClass]] to make sure it is a fully qualified class name.
     */
    public function validateModuleClass()
    {
        if (strpos($this->moduleClass, '\\') === false || Yii::getAlias('@' . str_replace('\\', '/', $this->moduleClass), false) === false) {
            $this->addError('moduleClass', 'Module class must be properly namespaced.');
        }
        if (empty($this->moduleClass) || substr_compare($this->moduleClass, '\\', -1, 1) === 0) {
            $this->addError('moduleClass', 'Module class name must not be empty. Please enter a fully qualified class name. e.g. "app\\modules\\admin\\Module".');
        }
    }
    /**
     * @return boolean the directory that contains the module class
     */
    public function getModulePath()
    {
        return Yii::getAlias('@' . str_replace('\\', '/', substr($this->moduleClass, 0, strrpos($this->moduleClass, '\\'))));
    }
    /**
     * @return string the controller namespace of the module.
     */
    public function getControllerNamespace()
    {
        return substr($this->moduleClass, 0, strrpos($this->moduleClass, '\\')) . '\controllers';
    }
}
