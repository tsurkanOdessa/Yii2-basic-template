<?php

namespace modules\pages;

use Yii;

/**
 * Class Bootstrap
 * @package modules\pages
 */
class Bootstrap
{
    /**
     * Bootstrap constructor.
     */
    public function __construct()
    {
        $this->registerTranslate();
        $this->registerRules();
    }

    /**
     * Translate
     */
    protected function registerTranslate()
    {
        $i18n = Yii::$app->i18n;
        $i18n->translations['modules/pages/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => '@modules/pages/messages',
            'fileMap' => [
                'modules/pages/module' => 'module.php',
            ],
        ];
    }

    /**
     * Rules
     */
    protected function registerRules()
    {
        $urlManager = Yii::$app->urlManager;
        $urlManager->addRules($this->rules());
    }

    /**
     * @return array
     */
    protected function rules()
    {
        $rules = [

            'pages' => 'pages/default/index',
            'pages/<_a:[\w\-]+>' => 'pages/default/<_a>',
        ];
        return $rules;
    }
}
