<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Tablacartagantt;
use frontend\models\Formulario;
use frontend\models\Postulacion;
use frontend\models\Concursante;
use frontend\models\TablacartaganttSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * TablacartaganttController implements the CRUD actions for Tablacartagantt model.
 */
class TablacartaganttController extends Controller
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
     * Creates a new Tablacartagantt model.
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

        $model = new Tablacartagantt();

        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
                return $this->redirect(['/site/section6', 'id_postulacion' => $id_postulacion]);
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
     * Updates an existing Tablacartagantt model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    {
        $id_usuario_actual=\Yii::$app->user->id;
        $buscaConcursante = Concursante::find()->where(['id' => $id_usuario_actual])->one();

        $request = Yii::$app->request;
        $id_tabla_cartaGantt=$request->get('id_tabla_cartaGantt');
        $id_postulacion = $request->get('id_postulacion');


        $buscaPostulacion = Postulacion::find()->where(['and',['id_postulacion' => $id_postulacion],['id_concursante' => $buscaConcursante->id_concursante]])->one();
        $model = $this->findModel($id_tabla_cartaGantt);
        if($buscaPostulacion != null && $model != null){


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/site/section6', 'id_postulacion' => $id_postulacion]);
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
     * Deletes an existing Tablacartagantt model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete()
    {

        $id_usuario_actual=\Yii::$app->user->id;
        $buscaConcursante = Concursante::find()->where(['id' => $id_usuario_actual])->one();


        $request = Yii::$app->request;
        $id_tabla_cartaGantt=$request->get('id_tabla_cartaGantt');
        $id_postulacion = $request->get('id_postulacion');
        $buscaPostulacion = Postulacion::find()->where(['and',['id_postulacion' => $id_postulacion],['id_concursante' => $buscaConcursante->id_concursante]])->one();
        $buscaTablaGantt = Tablacartagantt::find()->where(['id_tabla_cartaGantt' => $id_tabla_cartaGantt])->one();
        if($buscaPostulacion != null && $buscaTablaGantt != null){

        $this->findModel($id_tabla_cartaGantt)->delete();

        return $this->redirect(['/site/section6', 'id_postulacion' => $id_postulacion]);

        }else{
            throw new NotFoundHttpException('La página solicitada no existe.');
        } 

    }

    /**
     * Finds the Tablacartagantt model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tablacartagantt the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tablacartagantt::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('La página solicitada no existe.');
        }
    }
}
