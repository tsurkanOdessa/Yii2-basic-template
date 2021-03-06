<?php
$identity = Yii::$app->user->identity;
?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">

                <p><?php  echo $identity->username; ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Управление', 'options' => ['class' => 'header']],
                    ['label' => 'Основное', 'icon' => 'file-code-o', 'url' => ['/admin']],
                    ['label' => 'Пользователи', 'icon' => 'file-code-o', 'url' => ['/admin/user/index'],'visible' => Yii::$app->user->can(\modules\rbac\models\Permission::PERMISSION_MANAGER_USERS)],
                    ['label' => 'R.B.A.C.', 'icon' => 'dashboard', 'url' => ['/rbac/roles/index'],'visible' => Yii::$app->user->can(\modules\rbac\models\Permission::PERMISSION_MANAGER_RBAC)],
                    [
                        'label' => 'Управление страницами',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Страницы', 'icon' => 'file-code-o', 'url' => ['/pages/index'],],
                            ['label' => 'Контент', 'icon' => 'file-code-o', 'url' => ['/pages/content/index'],],
                        ],
                    ],
                    [
                        'label' => 'Системные инструменты',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'],],
                            ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug'],],
                            [
                                'label' => 'Level One',
                                'icon' => 'circle-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
                                    [
                                        'label' => 'Level Two',
                                        'icon' => 'circle-o',
                                        'url' => '#',
                                        'items' => [
                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
