<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use modules\rbac\widgets\RbacMenu;
use modules\rbac\Module;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $assignModel \modules\rbac\models\Assignment */

$this->title = Module::t('module', 'Role Based Access Control');
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'RBAC'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = Module::t('module', 'Assign');
?>

<div class="rbac-assign-index">
    <div class="row">
        <div class="col-lg-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Module::t('module', 'Menu') ?></h3>
                </div>
                <div class="panel-body">
                    <?= RbacMenu::widget() ?>
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <h2><?= Module::t('module', 'Assign') ?></h2>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'layout' => "{items}",
                'tableOptions' => [
                    'class' => 'table table-bordered table-hover',
                ],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'username',
                        'label' => Module::t('module', 'User'),
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'role',
                        'label' => Module::t('module', 'Role'),
                        'format' => 'raw',
                        'value' => function ($data) use ($assignModel) {
                            return $assignModel->getRoleName($data->id);
                        }
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'contentOptions' => [
                            'class' => 'action-column'
                        ],
                        'template' => '{view} {update} {revoke}',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', Url::to(['view', 'id' => $model->id]), [
                                    'title' => Module::t('module', 'View'),
                                    'data' => [
                                        'toggle' => 'tooltip',
                                        'pjax' => 0,
                                    ]
                                ]);
                            },
                            'update' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Url::to(['update', 'id' => $model->id]), [
                                    'title' => Module::t('module', 'Update'),
                                    'data' => [
                                        'toggle' => 'tooltip',
                                        'pjax' => 0,
                                    ]
                                ]);
                            },
                            'revoke' => function ($url, $model) {
                                $linkOptions = [];
                                /** @var object $identity */
                                $identity = Yii::$app->user->identity;
                                if ($model->id == $identity->id) {
                                    $linkOptions = [
                                        'style' => 'display: none;',
                                    ];
                                }
                                return Html::a('<span class="glyphicon glyphicon-remove"></span>', Url::to(['revoke', 'id' => $model->id]), ArrayHelper::merge([
                                    'title' => Module::t('module', 'Revoke'),
                                    'data' => [
                                        'toggle' => 'tooltip',
                                        'method' => 'post',
                                        'confirm' => Module::t('module', 'Do you really want to untie the user from the role?'),
                                    ],
                                ], $linkOptions));
                            },
                        ]
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
