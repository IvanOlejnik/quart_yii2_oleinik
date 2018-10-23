<?php

namespace frontend\controllers;

use Yii;
use common\models\Payments;
use common\models\PaymentsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PaymentsController implements the CRUD actions for Payments model.
 */
class PaymentsController extends Controller
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
     * Lists all Payments models.
     * @return mixed
     */
    public function actionIndex()
    {   
        $userId = Yii::$app->user->id;
        $searchModel = new PaymentsSearch();
        $dataProvider = $searchModel->search($userId);
        
        $model = new Payments();
        $model->price = 15;
        $model->user_id = $userId;
        
        if ($model->load(Yii::$app->request->post())) {
            $model->amount = $model->count * $model->price;
            $model->save();
            return $this->redirect(['index']);
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
        
        
    }

    /**
     * Creates a new Payments model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionBuy()
    {
        $model = new Payments();
        $userId = Yii::$app->user->id;
        $model->price = 15;
        $model->user_id = $userId;

        if ($model->load(Yii::$app->request->post())) {
            $model->amount = $model->count * $model->price;
            $model->save();
            return $this->redirect(['index']);
        }

        return $this->render('buy', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Payments model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Payments the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Payments::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
