<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pages\models\PageContent */

$this->title = Yii::t('app', 'Create Page Content');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Page Contents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-content-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
