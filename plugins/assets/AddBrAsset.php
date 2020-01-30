<?php

namespace app\plugins\assets;

use yii\web\AssetBundle;

class AddBrAsset extends AssetBundle
{
    public $sourcePath = "@app/plugins";

    public $js = [
        'js/addBrPlugin.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];

    public $publishOptions = [
        'forceCopy' => true,
    ];
}