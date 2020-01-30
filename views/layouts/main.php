<?php

use app\assets\AppAsset;
use yii\helpers\Html;

AppAsset::register( $this );

$nav = Yii::$app->setting->get( 'siteNav' );

?>

<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Yii::$app->setting->get( 'siteName' ) . ' | ' . Html::encode( $this->title ) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>

    <div class="wrap">

        <?php echo $this->render( 'header.php' ); ?>
        <?php if ($nav == 'top'): ?>
            <br>
            <br>
        <?php endif; ?>
        <div class="container-fluid">
            <div class="row-fluid">
                <header class="col-md-3">
                    <?php if ($nav == 'left'): ?>
                        <?php echo $this->render( 'left.php' ); ?>
                    <?php endif; ?>
                </header>
                <main class="col-md-<?= $nav == 'top' ? 12 : 9; ?>">
                    <?= $content ?>
                </main>
            </div>
        </div>

    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; <?= Yii::$app->name . ' ' . date( 'Y' ) ?></p>
            <p class="pull-right">Powered by <a href="http://www.yiiframework.com/" target="_blank">Yii Framework</a>
            </p>
        </div>
    </footer>


    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>