<?php

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

