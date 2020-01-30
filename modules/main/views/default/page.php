<?php

use app\modules\pages\models\PageContent;
use app\modules\pages\models\Pages;
use modules\main\Module;
use yii\helpers\Html;

$title = '';
if (isset( $_GET['page_id'] )) {
    $page_id = $_GET['page_id'];

    if (($model = Pages::findOne( $page_id )) !== null) {
        $title = $model->title;
    }
}


$content = '';
if (($modelContent = PageContent::getContent($page_id)) !== null) {

       $content = $modelContent->content;
}

$this->title = Module::t('module', $title);
$this->params['breadcrumbs'][] = $title;

?>

<div class="main-default-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="container">
        <?php echo $content ?>
    </div>

</div>
