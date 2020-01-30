<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

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
    if (!empty($model->id)) {
        $exclude = $model->id;
    }
    $parents = $model::getTree($exclude, true);
    echo $form->field($model, 'page_id')->dropDownList($parents);
    ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
