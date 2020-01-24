<?php

namespace modules\main\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use modules\main\models\ContactForm;

/**
 * Default controller for the `main` module
 */
class DefaultController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],

        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render( 'index' );
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if (Yii::$app->user->isGuest) {
            $model->scenario = $model::SCENARIO_GUEST;
        } else {
            $user = Yii::$app->user;
            /** @var \modules\users\models\User $identity */
            $identity = $user->identity;
            $model->name = $identity->username;
            $model->email = $identity->email;
        }

        if ($model->load( Yii::$app->request->post() ) && $model->contact( Yii::$app->params['adminEmail'] )) {
            Yii::$app->session->setFlash( 'contactFormSubmitted' );

            return $this->refresh();
        }
        return $this->render( 'contact', [
            'model' => $model,
        ] );
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render( 'about' );
    }


    /**
     * @inheritdoc
     */
    public function init()
    {
        $css_theme = Yii::$app->setting->get( 'themes' );
        Yii::$app->assetManager->bundles['yii\bootstrap\BootstrapAsset'] = [
                'sourcePath' => '@app/assets/bootstrap',
                'css' => [
                    YII_ENV_DEV ? $css_theme . '/bootstrap.css' : $css_theme . '/bootstrap.min.css',
                ]
        ];
    }
}
