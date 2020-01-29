<?php

use app\assets\DatePickerAsset;
use app\modules\pages\models\Pages;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\JsExpression;
use modules\pages\Module;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pages\models\search\PagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$language = substr( \Yii::$app->language, 0, 2 );
DatePickerAsset::$language = $language;
DatePickerAsset::register( $this );

$js = new JsExpression( "
    initDatePicker();
    $(document).on('ready pjax:success', function() {
       initDatePicker();
    });

    function initDatePicker()
    {
        /** @see http://bootstrap-datepicker.readthedocs.io/en/latest/index.html */
        $('#datepicker').datepicker({
            language: '{$language}',
            autoclose: true,
            format: 'dd.mm.yyyy',
            zIndexOffset: 1001,
            orientation: 'bottom'
        });
    }
" );
$this->registerJs( $js, \yii\web\View::POS_END );
$this->title = Module::t( 'module', 'Pages' );
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pages-index">

    <h1><?= Html::encode( $this->title ) ?></h1>

    <div class="row">
        <div class="col-md-12">
            <div class="pull-right">
                <?= Html::a( Module::t( 'module', 'Create Pages' ), ['create'], ['class' => 'btn btn-success'] ) ?>
            </div>
            <div class="col-md-1">
                <?= app\widgets\PageSize::widget( [
                    'label' => '',
                    'defaultPageSize' => 25,
                    'sizes' => [2 => 2, 5 => 5, 10 => 10, 15 => 15, 20 => 20, 25 => 25, 50 => 50, 100 => 100, 200 => 200],
                    'options' => [
                        'class' => 'form-control'
                    ]
                ] ); ?>
            </div>
        </div>
    </div>

    <?= GridView::widget( [
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'parent_id',
                'filter' => Html::activeDropDownList( $searchModel, 'parent_id', $searchModel::getTree( $searchModel->id, false, false ), [
                    'class' => 'form-control',
                    'prompt' => Module::t( 'module', '- all -' ),
                    'data' => [
                        'pjax' => true,
                    ],
                ] ),
                'label' => Module::t( 'module', 'Parent ID' ),
                'format' => 'raw',
                'content' => function ($data) {
                    return Pages::getPage($data->parent_id)['name'];
                },
                'headerOptions' => ['width' => '300'],
                'contentOptions' => [
                    'style' => 'width:200px',
                ],
            ],

            [
                'attribute' => 'name',
                'filter' => Html::activeInput( 'text', $searchModel, 'name', [
                    'class' => 'form-control',
                    'placeholder' => Module::t( 'module', '- text -' ),
                    'data' => [
                        'pjax' => true,
                    ],
                ] ),
                'label' => Module::t( 'module', 'Name' ),
                'format' => 'raw',
                'headerOptions' => ['width' => '300'],
            ],

            [
                'attribute' => 'title',
                'filter' => Html::activeInput( 'text', $searchModel, 'title', [
                    'class' => 'form-control',
                    'placeholder' => Module::t( 'module', '- text -' ),
                    'data' => [
                        'pjax' => true,
                    ],
                ] ),
                'label' => Module::t( 'module', 'Title' ),
                'format' => 'raw',
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ] ); ?>

</div>
