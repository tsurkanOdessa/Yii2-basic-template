<?php

use yii\helpers\ArrayHelper;

$params = ArrayHelper::merge(
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'name' => 'Yii2-basic-start',
    'language' => 'ru',
    'basePath' => dirname(__DIR__),
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'bootstrap' => [
        'log',
        'modules\main\Bootstrap',
        'modules\users\Bootstrap',
        'modules\admin\Bootstrap',
        'modules\rbac\Bootstrap',
    ],
    'modules' => [
        'main' => [
            'class' => 'modules\main\Module',
        ],
        'users' => [
            'class' => 'modules\users\Module',
        ],
        'rbac' => [
            'class' => 'modules\rbac\Module',
            'layout' => '@app/modules/render/layouts/main',
            'params' => [
                'userClass' => 'modules\users\models\User',
            ]
        ],
        'admin' => [
            'class' => 'modules\admin\Module',
            'layout' => '@app/modules/render/layouts/main'
        ],
        'setting' => [
                'class' => 'funson86\setting\Module',
                'controllerNamespace' => 'funson86\setting\controllers'
            ],
    ],
    'components' => [
        'setting' => [
            'class' => 'funson86\setting\Setting',
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'charset' => 'utf8',
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<_a:(error)>' => 'site/<a>',
            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'class' => 'yii\log\Dispatcher',
        ],
    ],
    'params' => $params,
];
