<?php

use yii\helpers\Html;
use modules\pages\Module;
/* @var $this yii\web\View */
/* @var $model app\modules\pages\models\PageContent */

$this->title = Module::t('module', 'Update Page Content: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'Page Contents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Module::t('module', 'Update');
?>
<div class="page-content-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
