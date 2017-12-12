<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Tablaitemfinanciamiento;
use frontend\models\TablaitemfinanciamientoSearch;
use frontend\models\Formulario;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\Concursante;
use frontend\models\Postulacion;

/**
 * TablaitemfinanciamientoController implements the CRUD actions for Tablaitemfinanciamiento model.
 */
class TablaitemfinanciamientoController extends Controller
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
     * Creates a new Tablaitemfinanciamiento model.
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

        $model = new Tablaitemfinanciamiento();


        if ($model->load(Yii::$app->request->post())) {
             
            $monto = (float) preg_replace('/[^0-9.]/', '', $model->monto);
            $model->monto= $monto;
        $buscaFormulario = Formulario::find()->where(['id_postulacion' => $id_postulacion])->one();
        $buscaFinanciamientos = Tablaitemfinanciamiento::find()->where(['id_formulario' => $buscaFormulario->id_formulario])->all();  
        if($buscaFinanciamientos != null){

            $costoTotalFinanciamiento=0;
            foreach ($buscaFinanciamientos as $financiamiento) {
                $costoTotalFinanciamiento+= $financiamiento->monto;
            }

            $costoTotalFinanciamiento+= $model->monto;

            if($costoTotalFinanciamiento > 999999999){
                return $this->redirect(['/site/section5', 'id_postulacion' => $id_postulacion]);
            }else{

                $aportePropio = (float) preg_replace('/[^0-9.]/', '', $buscaFormulario->financiamiento_aporte_propio);
                $aporteTerceros = (float) preg_replace('/[^0-9.]/', '', $buscaFormulario->financiamiento_aporte_terceros);
                $aporteSolicitado = $costoTotalFinanciamiento;
                $buscaFormulario->financiamiento_aporte_solicitado=$aporteSolicitado;
                $aporteTotal=$aporteSolicitado+$aportePropio+$aporteTerceros;
                $buscaFormulario->financiamiento_aporteTotal_proyecto = $aporteTotal.'';
                $model->save();
                $buscaFormulario->save();
                return $this->redirect(['/site/section5', 'id_postulacion' => $id_postulacion]);              
            }

        }else{
                $aportePropio = (float) preg_replace('/[^0-9.]/', '', $buscaFormulario->financiamiento_aporte_propio);
                $aporteTerceros = (float) preg_replace('/[^0-9.]/', '', $buscaFormulario->financiamiento_aporte_terceros);
                $aporteSolicitado = $model->monto;
                $buscaFormulario->financiamiento_aporte_solicitado=$aporteSolicitado;
                $aporteTotal=$aporteSolicitado+$aportePropio+$aporteTerceros;
                $buscaFormulario->financiamiento_aporteTotal_proyecto = $aporteTotal.'';
                $model->save();
                $buscaFormulario->save();
                return $this->redirect(['/site/section5', 'id_postulacion' => $id_postulacion]); 
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
     * Updates an existing Tablaitemfinanciamiento model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
	public function actionUpdate()
    {

        $id_usuario_actual=\Yii::$app->user->id;
        $buscaConcursante = Concursante::find()->where(['id' => $id_usuario_actual])->one();

        $request = Yii::$app->request;
        $id_tabla_item_financiamiento=$request->get('id_tabla_item_financiamiento');
        $id_postulacion = $request->get('id_postulacion');

        $buscaPostulacion = Postulacion::find()->where(['and',['id_postulacion' => $id_postulacion],['id_concursante' => $buscaConcursante->id_concursante]])->one();
        $model = $this->findModel($id_tabla_item_financiamiento);

        if($buscaPostulacion != null && $model != null){

   
       if ($model->load(Yii::$app->request->post())) {
             
            $monto = (float) preg_replace('/[^0-9.]/', '', $model->monto);
            $model->monto= $monto;
            $buscaFormulario = Formulario::find()->where(['id_postulacion' => $id_postulacion])->one();
            $buscaFinanciamientos = Tablaitemfinanciamiento::find()->where(['id_formulario' => $buscaFormulario->id_formulario])->all();

            $costoTotalFinanciamiento=0;
            foreach ($buscaFinanciamientos as $financiamiento) {
                if($financiamiento->id_tabla_item_financiamiento!= $id_tabla_item_financiamiento){
                    $costoTotalFinanciamiento+= $financiamiento->monto;
                }
            }

            $costoTotalFinanciamiento+= $model->monto;

            if($costoTotalFinanciamiento > 999999999){
                return $this->redirect(['/site/section5', 'id_postulacion' => $id_postulacion]);
            }else{

                $aportePropio = (float) preg_replace('/[^0-9.]/', '', $buscaFormulario->financiamiento_aporte_propio);
                $aporteTerceros = (float) preg_replace('/[^0-9.]/', '', $buscaFormulario->financiamiento_aporte_terceros);
                $aporteSolicitado = $costoTotalFinanciamiento;
                $buscaFormulario->financiamiento_aporte_solicitado=$aporteSolicitado;
                $aporteTotal=$aporteSolicitado+$aportePropio+$aporteTerceros;
                $buscaFormulario->financiamiento_aporteTotal_proyecto = $aporteTotal.'';
                $model->save();
                $buscaFormulario->save();
                return $this->redirect(['/site/section5', 'id_postulacion' => $id_postulacion]);              
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
     * Deletes an existing Tablaitemfinanciamiento model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete()
    {

        $id_usuario_actual=\Yii::$app->user->id;
        $buscaConcursante = Concursante::find()->where(['id' => $id_usuario_actual])->one();

        $request = Yii::$app->request;
        $id_tabla_item_financiamiento=$request->get('id_tabla_item_financiamiento');
        $id_postulacion = $request->get('id_postulacion');

        $buscaPostulacion = Postulacion::find()->where(['and',['id_postulacion' => $id_postulacion],['id_concursante' => $buscaConcursante->id_concursante]])->one();
        $buscaTablaItemFinanciamiento = Tablaitemfinanciamiento::find()->where(['id_tabla_item_financiamiento' => $id_tabla_item_financiamiento ])->one();

        if($buscaPostulacion != null && $buscaTablaItemFinanciamiento != null){

        $buscaFormulario = Formulario::find()->where(['id_postulacion' => $id_postulacion])->one();
        $buscaFinanciamientos = Tablaitemfinanciamiento::find()->where(['id_formulario' => $buscaFormulario->id_formulario])->all();

            $costoTotalFinanciamiento=0;
            foreach ($buscaFinanciamientos as $financiamiento) {
                if($financiamiento->id_tabla_item_financiamiento!= $id_tabla_item_financiamiento){
                    $costoTotalFinanciamiento+= $financiamiento->monto;
                }
            }

                $aportePropio = (float) preg_replace('/[^0-9.]/', '', $buscaFormulario->financiamiento_aporte_propio);
                $aporteTerceros = (float) preg_replace('/[^0-9.]/', '', $buscaFormulario->financiamiento_aporte_terceros);
                $aporteSolicitado = $costoTotalFinanciamiento;
                $buscaFormulario->financiamiento_aporte_solicitado=$aporteSolicitado;
                $aporteTotal=$aporteSolicitado+$aportePropio+$aporteTerceros;
                $buscaFormulario->financiamiento_aporteTotal_proyecto = $aporteTotal.'';
                $buscaFormulario->save();


        $this->findModel($id_tabla_item_financiamiento)->delete();

        return $this->redirect(['/site/section5', 'id_postulacion' => $id_postulacion]);

        }else{
            throw new NotFoundHttpException('La página solicitada no existe.');
        } 

    }

    /**
     * Finds the Tablaitemfinanciamiento model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tablaitemfinanciamiento the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tablaitemfinanciamiento::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('La página solicitada no existe.');
        }
    }
}
