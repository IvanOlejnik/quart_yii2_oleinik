<?php

namespace frontend\controllers;

use Yii;
use common\models\Resources;
use common\models\ResourcesSearch;
use common\models\UserResources;
use common\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\SearchResoursForm;
use app\models\UploadForm;
use yii\web\UploadedFile;

/**
 * ResourcesController implements the CRUD actions for Resources model.
 */
class ResourcesController extends Controller
{
    public $name;
    public $res_id;
    public $count;
    
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
        $userId = Yii::$app->user->id;
        $formModel = new searchResoursForm();
        if ($formModel->load(Yii::$app->request->post()) && $formModel->validate()) {
            $this->res_id = $formModel->id;
            $this->name = $formModel->name;
            $resourcesData = User::findIdentity($userId)
                ->getResourcesUser()
                ->with(['resources' => function ($query) {
                    $query->andFilterWhere(['id' => $this->res_id])
                          ->andFilterWhere(['like', 'name', $this->name]);
                }])
                ->asArray()
                ->all();  
        }else{
            $resourcesData = User::findIdentity($userId)
                ->getResourcesUser()->orderBy(['count' => SORT_ASC])
                ->with('resources')
                ->with('user')
                ->asArray()
                ->all();  
                
                /*
                
                         $resourcesData = User::findIdentity($userId)
                ->getResourcesUser()
                ->with('resources')
                ->with('user')
                ->asArray()
                ->all();  

          //  $resourcesData = Resources::find()//->one()
              //  ->getUsers()
               // ->with('resources')
               // ->with('user')
             //   ->asArray()
              //  ->all();                  
               // getUserResources
                */
        }
            
        return $this->render('index', [
            'resourcesData' => $resourcesData,
            'formModel' => $formModel,
        ]);
    }

    public function actionUpdate($id)
    {   
        $userId = Yii::$app->user->id;
        $this->res_id = $id;

        $resourcesData = User::findIdentity($userId)
                ->getResourcesUser()
                ->andFilterWhere(['resources_id' => $this->res_id])
                ->one();  

        if (Yii::$app->request->isPost) {
            $resourcesData->load(Yii::$app->request->post()); 
            $resourcesData->save();
            return $this->redirect(['index']);
        }else{
            return $this->render('update', [
                'model' => $resourcesData,
            ]);      
        }       
    }




    /**
     * Displays a single Resources model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $modelUserResources = new UserResources();

        return $this->render('view', [
            'model' => $modelUserResources->findModel($id),
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
                $modelResources->icon = '/resourse/icon/' . $modelUpload->imageFile->baseName . '.' . $modelUpload->imageFile->extension;
                $modelResources->save();
                return $this->redirect(['view', 'id' => $modelResources->id]);
            }
        }
        else{
             if ($modelResources->load(Yii::$app->request->post()) &&  $modelResources->save()) {
                return $this->redirect(['view', 'id' => $modelResources->id]);
            }    
        }   
        
        return $this->render('create', [
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
        if (($model = Resources::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
