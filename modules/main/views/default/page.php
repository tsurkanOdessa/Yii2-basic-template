<?php

use app\modules\pages\models\PageContent;
use app\modules\pages\models\Pages;


$title = '';
if (isset( $_GET['page_id'] )) {
    $page_id = $_GET['page_id'];

    if (($model = Pages::findOne( $page_id )) !== null) {
        $title = $model->title;
    }
}
$this->title = $title;

$content = '';
if (($modelContent = PageContent::getContent($page_id)) !== null) {

       $content = $modelContent->content;
}

?>

<div class="main-default-index">
    <?php echo $content ?>
</div>
