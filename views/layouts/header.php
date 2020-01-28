<?php
    $nav = Yii::$app->setting->get( 'siteNav' );
?>


<?php if ($nav == 'top') :?>
    <?php echo $this->render( 'top.php' ); ?>
<?php elseif ($nav == 'left'): ?>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">
                    <img src="<?php echo Yii::$app->request->baseUrl; ?>/images/logo.png" width="30" height="30" alt="">
                </a>
            </div>
        </div>
    </nav>
<?php endif;?>



