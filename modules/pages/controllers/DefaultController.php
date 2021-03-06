<?php

namespace modules\pages\controllers;


use Yii;
use app\modules\pages\models\Pages;
use app\modules\pages\models\search\PagesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PagesController implements the CRUD actions for Pages model.
 */
class DefaultController extends Controller
{
    /** @var  string|bool $jsFile */
    protected $jsFile;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->processRegisterJs();

    }

    /**
     * Publish and register the required JS file
     */
    protected function processRegisterJs()
    {
        $this->jsFile = '@modules/pages/views/default/ajax/ajax.js';
        $assetManager = Yii::$app->assetManager;
        $assetManager->publish($this->jsFile);
        $url = $assetManager->getPublishedUrl($this->jsFile);
        $this->view->registerJsFile($url,
            ['depends' => 'yii\web\JqueryAsset',] // depends
        );
    }

    /**
     * Lists all Pages models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PagesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Pages model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Pages model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Pages();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Pages model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Pages model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Pages model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Pages the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pages::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actions()
    {
        return [
            'image-upload' => [
                'class' => 'vova07\imperavi\actions\UploadFileAction',
                'url' => 'http://'.$_SERVER['SERVER_NAME'].'/uploads/img/', // Directory URL address, where files are stored.
                'path' => '@app/web/uploads/img', // Or absolute path to directory where files are stored.
            ],
            'images-get' => [
                'class' => 'vova07\imperavi\actions\GetImagesAction',
                'url' => 'http://'.$_SERVER['SERVER_NAME'].'/uploads/img/', // Directory URL address, where files are stored.
                'path' => '@app/web/uploads/img', // Or absolute path to directory where files are stored.
                'options' => ['only' => ['*.jpg', '*.jpeg', '*.JPG', '*.JPEG', '*.png', '*.PNG', '*.gif', '*.ico']], // These options are by default.
            ],
            'file-delete' => [
                'class' => 'vova07\imperavi\actions\DeleteFileAction',
                'url' => 'http://'.$_SERVER['SERVER_NAME'].'/uploads/img/', // Directory URL address, where files are stored.
                'path' => '@app/web/uploads/img', // Or absolute path to directory where files are stored.
            ],
            'file-upload' => [
                'class' => 'vova07\imperavi\actions\UploadFileAction',
                'url' => 'http://'.$_SERVER['SERVER_NAME'].'/uploads/files/', // Directory URL address, where files are stored.
                'path' => '@app/web/uploads/files', // Or absolute path to directory where files are stored.
                'uploadOnlyImage' => false, // For any kind of files uploading.
                'unique' => false,
                'replace' => true, // By default it throw an excepiton instead.
                'translit' => true,
            ],
            'files-get' => [
                'class' => 'vova07\imperavi\actions\GetFilesAction',
                'url' => 'http://'.$_SERVER['SERVER_NAME'].'/uploads/files/', // Directory URL address, where files are stored.
                'path' => '@app/web/uploads/files', // Or absolute path to directory where files are stored.
                'options' => ['only' => ['*.pdf', '*.pptx', '*.zip', '*.doc', '*.docx', '*.xls', '*.xlsx', '*.txt', '*.md']], // These options are by default.
            ],
        ];
    }


}
