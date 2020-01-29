<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Pages */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pages-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    // при редактировании существующей категории нельзя допустить, чтобы
    // в качестве родителя была выбрана эта же категория или ее потомок
    $exclude = 0;
    if (!empty($model->id)) {
        $exclude = $model->id;
    }
    $parents = $model::getTree($exclude, true);
    echo $form->field($model, 'parent_id')->dropDownList($parents);
    ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sort_order')->textInput() ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
