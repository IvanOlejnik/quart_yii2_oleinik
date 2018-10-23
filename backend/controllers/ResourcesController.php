<?php

namespace backend\controllers;

use Yii;
use common\models\Resources;
use common\models\ResourcesSearch;
use common\models\User;
use common\models\UserResources;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\UploadForm;
use yii\web\UploadedFile;

/**
 * ResourcesController implements the CRUD actions for Resources model.
 */
class ResourcesController extends Controller
{
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
     * Lists all Resources models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ResourcesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Resources model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'modelResources' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Resources model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $modelResources = new Resources();
        $modelUpload = new UploadForm();
        
        if($modelUpload->imageFile = UploadedFile::getInstance($modelUpload, 'imageFile')){
            $modelUpload->imageFile->saveAs(Yii::getAlias('@webroot') . '/resourse/icon/' 
            . $modelUpload->imageFile->baseName . '.' . $modelUpload->imageFile->extension);
            if ($modelResources->load(Yii::$app->request->post())) {
                $modelResources->icon = '/backend/web/resourse/icon/' . $modelUpload->imageFile->baseName . '.' . 
                $modelUpload->imageFile->extension;
                if ($modelResources->save()) {
                    $this->addResourcesAllUsers($modelResources->id);
                    return $this->redirect(['index']);
                }
            }
        }
        else{
            if ($modelResources->load(Yii::$app->request->post()) &&  $modelResources->save()) {
                $this->addResourcesAllUsers($modelResources->id);
                return $this->redirect(['index']);
            }    
        }   
        
        return $this->render('create', [
            'modelResources' => $modelResources,
            'modelUpload' => $modelUpload,
        ]);
    }

    public function addResourcesAllUsers($id){
        $modelResources = Resources::findOne($id);
        $modelUser = new User();
        $arrUsers = $modelUser->find()->all();
        foreach ($arrUsers as $user) {
            $modelUserRes = new UserResources();
            $modelUserRes->user_id = $user->id;
            $modelUserRes->resources_id = $modelResources->id;
            $modelUserRes->save();          
        }
    }

    /**
     * Updates an existing Resources model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $modelResources = $this->findModel($id);
        $modelUpload = new UploadForm();

        if($modelUpload->imageFile = UploadedFile::getInstance($modelUpload, 'imageFile')){
            $modelUpload->imageFile->saveAs(Yii::getAlias('@webroot') . '/resourse/icon/' 
            . $modelUpload->imageFile->baseName . '.' . $modelUpload->imageFile->extension);
            if ($modelResources->load(Yii::$app->request->post())) {
                $modelResources->icon = '/backend/web/resourse/icon/' . $modelUpload->imageFile->baseName . '.' . $modelUpload->imageFile->extension;
                $modelResources->save();
                return $this->redirect(['view', 'id' => $modelResources->id]);
            }
        }
        else{
             if ($modelResources->load(Yii::$app->request->post()) &&  $modelResources->save()) {
                return $this->redirect(['view', 'id' => $modelResources->id]);
            }    
        }   

        return $this->render('update', [
            'modelResources' => $modelResources,
            'modelUpload' => $modelUpload,
        ]);
    }

    /**
     * Deletes an existing Resources model.
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
     * Finds the Resources model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Resources the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($modelResources = Resources::findOne($id)) !== null) {
            return $modelResources;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
