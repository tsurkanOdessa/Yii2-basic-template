<?php

use app\modules\pages\models\Pages;
use app\modules\pages\models\search\PagesSearch;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use modules\pages\Module;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Module::t('module', 'Page Contents');
$this->params['breadcrumbs'][] = $this->title;
$searchModel = new PagesSearch();
?>
<div class="page-content-index">

    <?php Pjax::begin(); ?>

    <p>
        <?= Html::a(Module::t('module', 'Create Page Content'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'parent_id',
                'filter' => Html::activeDropDownList( $searchModel, 'id', $searchModel::getTree( $searchModel->id, false, false ), [
                    'class' => 'form-control',
                    'prompt' => Module::t( 'module', '- all -' ),
                    'data' => [
                        'pjax' => true,
                    ],
                ] ),
                'label' => Module::t( 'module', 'Parent ID' ),
                'format' => 'raw',
                'content' => function ($data) {
                    return Pages::getPage($data->page_id)['name'];
                },
                'headerOptions' => ['width' => '300'],
                'contentOptions' => [
                    'style' => 'width:200px',
                ],
            ],
            'content:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
