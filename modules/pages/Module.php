<?php

namespace modules\pages;

use Yii;
use yii\filters\AccessControl;

/**
 * Class Module
 * @package modules\pages
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['viewAdminPage'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'modules\pages\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->setViewPath('@modules/pages/views');
    }

    /**
     * @param string $category
     * @param string $message
     * @param array $params
     * @param null|string $language
     * @return string
     */
    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/pages/' . $category, $message, $params, $language);
    }
}
