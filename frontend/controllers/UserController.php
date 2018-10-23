<?php

namespace frontend\controllers;

use Yii;
use common\models\User;
use common\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use common\models\Resources;
use common\models\ResourcesSearch;
use yii\base\Model;
use yii\web\UploadedFile;
use app\models\UploadForm;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $id = Yii::$app->user->id;
        $model = $this->findModel($id);
        $modelUpload = new UploadForm();

        if($modelUpload->imageFile = UploadedFile::getInstance($modelUpload, 'imageFile')){
            $modelUpload->imageFile->saveAs(Yii::getAlias('@webroot') . '/resourse/avatar/' 
            . $modelUpload->imageFile->baseName . '.' . $modelUpload->imageFile->extension);
            if ($model->load(Yii::$app->request->post())) {
                $model->avatar_image = '/resourse/avatar/' . $modelUpload->imageFile->baseName . '.' 
                . $modelUpload->imageFile->extension;
                $model->save();
                return $this->render('index', [
                    'model' => $model,
                    'modelUpload' => $modelUpload,
                ]);
            }
            //}
        }
        else{
            if ($model->load(Yii::$app->request->post()) &&  $model->save()) {
                return $this->render('index', [
                    'model' => $model,
                    'modelUpload' => $modelUpload,
                ]);
            }    
        }
        return $this->render('index', ['model' => $model,'modelUpload' => $modelUpload,]);    
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
