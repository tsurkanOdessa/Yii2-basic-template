<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

/**
 * Class SiteController
 * @package app\controllers
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {

        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',


            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        $css_theme = Yii::$app->setting->get( 'themes' );
        Yii::$app->assetManager->bundles['yii\bootstrap\BootstrapAsset'] = [
            'sourcePath' => '@app/assets/bootstrap',
            'css' => [
                YII_ENV_DEV ? $css_theme . '/bootstrap.css' : $css_theme . '/bootstrap.min.css',
            ]
        ];
    }
}
