<?php

use app\modules\pages\models\Pages;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use modules\main\Module as MainModule;
use modules\users\Module as UserModule;
use modules\admin\Module as AdminModule;
use yii\helpers\Html;
use yii\helpers\Url;

NavBar::begin( [
    'brandLabel' => Html::img( '@web/images/logo.png', ['alt' => Yii::$app->setting->get( 'siteName' ), 'class' => 'yii-logo'] ) . Yii::$app->setting->get( 'siteName' ),
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top',
    ],
] );
$menuItems = [
    [
        'label' => MainModule::t( 'module', 'Главная' ),
        'url' => ['/main/default/index']
    ],
    [
        'label' => MainModule::t( 'module', 'О нас' ),
        'url' => ['/main/default/about']
    ],
    [
        'label' => MainModule::t( 'module', 'Контакты' ),
        'url' => ['/main/default/contact']
    ],
];

$pages = Pages::find()->indexBy( 'id' )->asArray()->all();
$subPages = $pages;
$num = 3;
foreach ($pages as $page) {
    {
        if ($page['parent_id'] == 0) {
            $pageId = $page['id'];
            $subItems = [];
            foreach ($subPages as $subPage) {
                if ($pageId == $subPage['parent_id']) {
                    $subItems[] = [
                        'label' => $subPage['name'],
                        'url' => Url::to( ['/main/default/page/', 'page_id' => $subPage['id']] ),
                    ];
                }
            };

            if (count($subItems)>0){
                $thisPage = [
                    'label' => $page['name'],
                    'url' => Url::to( ['/main/default/page/', 'page_id' => $page['id']] ),
                ];
                array_unshift($subItems,$thisPage);
            }
            $menuItems[] = [
                'label' => $page['name'],
                'url' => Url::to( ['/main/default/page/', 'page_id' => $page['id']] ),
                'items' => $subItems
            ];

        }
    }
}

if (Yii::$app->user->isGuest) {
    $menuItems[] = ['label' => UserModule::t( 'module', 'Check in' ), 'url' => ['/users/default/signup']];
    $menuItems[] = [
        'label' => UserModule::t( 'module', 'Login' ),
        'url' => ['/users/default/login']
    ];
} else {
    /** @var modules\users\models\User $identity */
    $identity = Yii::$app->user->identity;
    $menuItems[] = [
        'label' => UserModule::t( 'module', 'My Menu' ),
        'items' => [
            [
                'label' => '<i class="glyphicon glyphicon-queen"></i> ' . AdminModule::t( 'module', 'Administration' ),
                'url' => ['/admin/default/index'],
                'visible' => Yii::$app->user->can( \modules\rbac\models\Permission::PERMISSION_VIEW_ADMIN_PAGE ),
            ],
            [
                'label' => '<i class="glyphicon glyphicon-lock"></i> ' . AdminModule::t( 'rbac', 'RBAC' ),
                'url' => ['/rbac/default/index'],
                'visible' => Yii::$app->user->can( \modules\rbac\models\Permission::PERMISSION_MANAGER_RBAC ),
            ],
            [
                'label' => '<i class="glyphicon glyphicon-eye-open"></i> ' . UserModule::t( 'module', 'Profile' ) . ' (' . $identity->username . ')',
                'url' => ['/users/profile/index'],
            ],
            [
                'label' => '<i class="glyphicon glyphicon-log-out"></i> ' . UserModule::t( 'module', 'Sign Out' ),
                'url' => ['/users/default/logout'],
                'linkOptions' => [
                    'data-method' => 'post'
                ]
            ],
        ],
    ];
}
echo Nav::widget( [
    'options' => ['class' => 'navbar-nav navbar-right'],
    'activateParents' => true,
    'encodeLabels' => false,
    'items' => array_filter( $menuItems )
] );
NavBar::end();