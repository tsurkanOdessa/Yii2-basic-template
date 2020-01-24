<?php

namespace modules\admin\controllers;

use funson86\setting\models\Setting;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use modules\admin\Module;

/**
 * Class DefaultController
 * @package modules\admin\controllers
 */
class DefaultController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        if(Yii::$app->request->isPost)
        {
            $setting = Yii::$app->request->post('Setting');
            foreach($setting as $key => $value) {
                Setting::updateAll(['value' => $value], ['code' => $key]);
            }
        }

        $settingParent = Setting::find()->where(['parent_id' => 0])->orderBy(['sort_order' => SORT_ASC])->all();
        return $this->render('index', ['settingParent' => $settingParent,]);
    }
        //return $this->render('index');
}
