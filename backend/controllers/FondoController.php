<?php

namespace backend\controllers;

use Yii;
use backend\models\Fondo;
use backend\models\FondoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\User;

/**
 * FondoController implements the CRUD actions for Fondo model.
 */
class FondoController extends Controller
{
    /**
     * @inheritdoc
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
     * Lists all Fondo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FondoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Fondo model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Fondo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Fondo();

        if ($model->load(Yii::$app->request->post())) {
            $model->fecha_creacion= date('Y-m-d', strtotime($model->fecha_creacion));
            date_default_timezone_set('America/Santiago');
            $fecha_actual= getdate();
            $model->save();
            return $this->redirect(['view', 'id' => $model->id_fondo]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Fondo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->fecha_creacion= date('Y-m-d', strtotime($model->fecha_creacion));
            date_default_timezone_set('America/Santiago');
            $fecha_actual= getdate();
            $model->save();
            return $this->redirect(['view', 'id' => $model->id_fondo]);
        } else {

            return $this->render('update', [

                'model' => $model,

            ]);
        }

    }

    /**
     * Deletes an existing Fondo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);


    }

    /**
     * Finds the Fondo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Fondo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Fondo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
