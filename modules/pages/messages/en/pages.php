<?php

use yii\helpers\ArrayHelper;

/** @var array $langFile */
$langFile = require(dirname(dirname(dirname(__DIR__))) . 'admin/messages/ru/module.php');

return ArrayHelper::merge($langFile, [
    'Pages' => 'Pages',
    'Create Pages' => 'Create Page',
    'Update Pages: {nameAttribute}' => 'Update Page: {nameAttribute}',

    'Create' => 'Create',
    'Update' => 'Update',
    'Save' => 'Save',
    'Delete' => 'Delete',

    '- all -' => '- all -',
    '- select -' => '- select -',
    '- text -' => '- text -',

]);
