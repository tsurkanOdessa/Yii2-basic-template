<?php

use app\modules\pages\models\Pages;
use yii\helpers\Url;
use kartik\sidenav\SideNav;
use modules\users\Module as UserModule;

$items = [
    [
        'url' => '/main/default/index',
        'label' => 'Главная',
        'icon' => 'home'
    ],
    [
        'url' => '/main/default/about',
        'label' => 'О нас',
        'icon' => 'globe'
    ],
    [
        'url' => '/main/default/contact',
        'label' => 'Контакты',
        'icon' => 'phone'
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
                $items[] = [
                    'label' => $page['name'],
                    'url' => Url::to( ['/main/default/page/', 'page_id' => $page['id']] ),
                    'items' => $subItems
                ];

            }
        }
    }




if (Yii::$app->user->isGuest) {
    $items[] =
        [
            'url' => '/users/default/signup',
            'label' => 'Регистрация',
            'icon' => 'phone'
        ];
    $items[] = [
        'url' => '/users/default/login',
        'label' => 'Войти',
        'icon' => 'registered'
    ];
} else {
    /** @var modules\users\models\User $identity */
    $identity = Yii::$app->user->identity;
    $items[] = [
        'label' => UserModule::t( 'module', 'Профиль' ),
        'items' => [
            [
                'label' => 'Панель управления',
                'url' => ['/admin/default/index'],
                'visible' => Yii::$app->user->can( \modules\rbac\models\Permission::PERMISSION_VIEW_ADMIN_PAGE ),
            ],
            [
                'label' => 'RBAC',
                'url' => ['/rbac/default/index'],
                'visible' => Yii::$app->user->can( \modules\rbac\models\Permission::PERMISSION_MANAGER_RBAC ),
            ],
            [
                'label' => 'Profile' . ' (' . $identity->username . ')',
                'url' => ['/users/profile/index'],
            ],
            [
                'label' => 'Выход',
                'url' => ['/users/default/logout'],
                'linkOptions' => [
                    'data-method' => 'post'
                ]
            ],
        ],
    ];
}

?>


<?php echo SideNav::widget( [
    'type' => SideNav::TYPE_DEFAULT,
    'heading' => 'Меню',
    'items' => $items

] );
?>

