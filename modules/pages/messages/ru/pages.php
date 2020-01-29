<?php

use yii\helpers\ArrayHelper;

/** @var array $langFile */
$langFile = require(dirname(dirname(dirname(__DIR__))) . 'pages/messages/ru/module.php');

return ArrayHelper::merge($langFile, [
    'Pages' => 'Страницы',
    'Create Pages' => 'Создание страницы',
    'Update Pages: {nameAttribute}' => 'Редактировать страницу: {nameAttribute}',
    'Parent ID' => 'Родитель',
    'Name' => 'Название',
    'Title' => 'Заголовок',
    'Create' => 'Создать',
    'Update' => 'Редактировать',
    'Save' => 'Сохранить',
    'Delete' => 'Удалить',

    '- all -' => '- все -',
    '- select -' => '- выбрать -',
    '- text -' => '- текст -',

]);
