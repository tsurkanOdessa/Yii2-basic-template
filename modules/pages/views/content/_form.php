<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;
use modules\pages\Module;
/* @var $this yii\web\View */
/* @var $model app\modules\pages\models\PageContent */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="page-content-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    // при редактировании существующей категории нельзя допустить, чтобы
    // в качестве родителя была выбрана эта же категория или ее потомок
    $exclude = 0;
    if (!empty( $model->id )) {
        $exclude = $model->id;
    }
    $parents = $model::getTree( $exclude, true );
    echo $form->field( $model, 'page_id' )->dropDownList( $parents );
    ?>

    <?php
    echo $form->field($model, 'content')->widget(Widget::className(), [
        'settings' => [
            'lang' => 'ru',
            'minHeight' => 400,
            'imageUpload' => Url::to(['default/image-upload']),
            'imageManagerJson' => Url::to(['/default/images-get']),
            'imageDelete' => Url::to(['/default/file-delete']),
            'fileManagerJson' => Url::to(['/default/files-get']),
            'fileUpload' => Url::to(['default/file-upload']),
            'allowedTags' => ['div','p', 'h1', 'h2', 'pre', 'br', 'hr', 'span'],
            'plugins' => [
                'alignment',
                'imagemanager',
                'table',
                'video',
                'clips',
                'fontcolor',
                'fullscreen',
               // 'textdirection',
                'imagemanager' => 'vova07\imperavi\bundles\ImageManagerAsset',
                'filemanager' => 'vova07\imperavi\bundles\FileManagerAsset',
                'addcode' => 'app\plugins\assets\AddBrAsset'
            ],
            'clips' => [
                ['Lorem ipsum...', 'Lorem...'],
                ['red', '<span class="label-red">red</span>'],
                ['green', '<span class="label-green">green</span>'],
                ['blue', '<span class="label-blue">blue</span>'],
            ],
        ],
        'plugins' => [
            'addcode' => 'app\plugins\assets\AddBrAsset'
        ]
    ]);

    ?>


    <div class="form-group">
        <?= Html::submitButton( Module::t( 'module', 'Save' ), ['class' => 'btn btn-success'] ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
