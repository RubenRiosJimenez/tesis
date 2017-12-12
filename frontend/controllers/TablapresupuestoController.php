<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Tablapresupuesto;
use frontend\models\TablapresupuestoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\Concursante;
use frontend\models\Postulacion;

/**
 * TablapresupuestoController implements the CRUD actions for Tablapresupuesto model.
 */
class TablapresupuestoController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['create','update','delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Creates a new Tablapresupuesto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $id_usuario_actual=\Yii::$app->user->id;
        $buscaConcursante = Concursante::find()->where(['id' => $id_usuario_actual])->one();

        $request = Yii::$app->request;
        $id_postulacion = $request->get('id_postulacion');

        $buscaPostulacion = Postulacion::find()->where(['and',['id_postulacion' => $id_postulacion],['id_concursante' => $buscaConcursante->id_concursante]])->one();

        if($buscaPostulacion != null){

        $model = new Tablapresupuesto();

        if ($model->load(Yii::$app->request->post())) {
            $cantidad = (float) preg_replace('/[^0-9.]/', '', $model->cantidad);
            $precioUni = (float) preg_replace('/[^0-9.]/', '', $model->precioUnitario);
            $total = $cantidad * $precioUni;
            $model->costoTotal = $total.'';
            if($model->save()){
                return $this->redirect(['/site/section4', 'id_postulacion' => $id_postulacion]);
            }else{
                 return $this->renderAjax('create', [
                'model' => $model,
            ]);
            }
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }

        }else{
            throw new NotFoundHttpException('La página solicitada no existe.');
        }

    }


    /**
     * Updates an existing Tablapresupuesto model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
   public function actionUpdate()
    {
        $id_usuario_actual=\Yii::$app->user->id;
        $buscaConcursante = Concursante::find()->where(['id' => $id_usuario_actual])->one();

        $request = Yii::$app->request;
        $id_tabla_presupuesto=$request->get('id_tabla_presupuesto');
        $id_postulacion = $request->get('id_postulacion');
        $model = $this->findModel($id_tabla_presupuesto);

        $buscaPostulacion = Postulacion::find()->where(['and',['id_postulacion' => $id_postulacion],['id_concursante' => $buscaConcursante->id_concursante]])->one();

        if($buscaPostulacion != null && $model != null){        

        if ($model->load(Yii::$app->request->post())) {

            $cantidad = (float) preg_replace('/[^0-9.]/', '', $model->cantidad);
            $precioUni = (float) preg_replace('/[^0-9.]/', '', $model->precioUnitario);
            $total = $cantidad * $precioUni;
            $model->costoTotal = $total.'';
          
        if($model->save()){
                return $this->redirect(['/site/section4', 'id_postulacion' => $id_postulacion]);
            }else{
                            return $this->renderAjax('update', [
                'model' => $model,
            ]);
            }
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }

        }else{
            throw new NotFoundHttpException('La página solicitada no existe.');
        }

    }

    /**
     * Deletes an existing Tablapresupuesto model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete()
    {

        $id_usuario_actual=\Yii::$app->user->id;
        $buscaConcursante = Concursante::find()->where(['id' => $id_usuario_actual])->one();

        $request = Yii::$app->request;
        $id_tabla_presupuesto=$request->get('id_tabla_presupuesto');
        $id_postulacion = $request->get('id_postulacion');

        $buscaPostulacion = Postulacion::find()->where(['and',['id_postulacion' => $id_postulacion],['id_concursante' => $buscaConcursante->id_concursante]])->one();
        $buscaTablaPresupuesto = Tablapresupuesto::find()->where(['id_tabla_presupuesto' => $id_tabla_presupuesto])->one();
        if($buscaPostulacion != null && $buscaTablaPresupuesto != null){    

        $this->findModel($id_tabla_presupuesto)->delete();

         return $this->redirect(['/site/section4', 'id_postulacion' => $id_postulacion]);

        }else{
            throw new NotFoundHttpException('La página solicitada no existe.');
        }

    }

    /**
     * Finds the Tablapresupuesto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tablapresupuesto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tablapresupuesto::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('La página solicitada no existe.');
        }
    }
}
