<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use backend\models\Tipoarchivo;
use backend\models\Evaluacion;
use backend\models\EvaluacionArchivo;
use backend\models\Estadoevaluacion;
use backend\models\Formulario;
use backend\models\Postulacion;
use backend\models\Concursante;
use backend\models\PostulacionSearchEvaluacion1;
use backend\models\TipoarchivoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use lavrentiev\widgets\toastr\Notification;
use backend\models\User;

/**
 * TipoarchivoController implements the CRUD actions for Tipoarchivo model.
 */
class TipoarchivoController extends Controller
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
                        'actions' => ['index', 'archivos'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Tipoarchivo models.
     * @return mixed
     */
    public function actionIndex()
    {

        if ( (User::isUserAdmin(Yii::$app->user->identity->id) == true) ){

        $request = Yii::$app->request;
        $id_postulacion = $request->get('id_postulacion');

        $buscaPostulacionValidar = Postulacion::find()->where(['id_postulacion' => $id_postulacion ])->one();

        if($buscaPostulacionValidar != null){

        $buscaEvaluacion = Evaluacion::find()->where(['id_postulacion'=>$id_postulacion])->one();

            if ($buscaEvaluacion->load(Yii::$app->request->post())) {

                if($buscaEvaluacion->id_estado == 2){
                        $buscaEvaluacionArchivo = EvaluacionArchivo::find()->where(['id_evaluacion'=>$buscaEvaluacion->id_evaluacion])->count();
                        $buscaTiposArchivos = Tipoarchivo::find()->count();
                        $buscaEvaluacionArchivosRevisados = EvaluacionArchivo::find()->where(['and',['id_evaluacion' => $buscaEvaluacion->id_evaluacion],['id_estado' => 3]])->count();
                        $buscaEvaluacionArchivosRevisados2 = EvaluacionArchivo::find()->where(['and',['id_evaluacion' => $buscaEvaluacion->id_evaluacion],['id_estado' => 4]])->count();
                        $buscaEvaluacionArchivosRevisados3 = EvaluacionArchivo::find()->where(['and',['id_evaluacion' => $buscaEvaluacion->id_evaluacion],['id_estado' => 2]])->count();
                        if(($buscaEvaluacionArchivo == $buscaTiposArchivos) && ($buscaEvaluacionArchivosRevisados + $buscaEvaluacionArchivosRevisados2 + $buscaEvaluacionArchivosRevisados3) == $buscaTiposArchivos){
                            if($buscaEvaluacion->observaciones_1 != null){
                                $buscaEvaluacion->puntaje_1 = 0;
                                $buscaEvaluacion->save();
                                Yii::$app->session->setFlash('success', 'Los datos de la evaluación han sido guardados correctamente.');
                                return Yii::$app->getResponse()->redirect(['/tipoarchivo/index', 'id_postulacion' => $id_postulacion]);

                            }else{
                                Yii::$app->session->setFlash('error', 'Antes de rechazar una postulación debe ingresar observaciones.');
                                $items=ArrayHelper::map(Estadoevaluacion::find()->all(),'id_estado','descripcion_estado');
                                $searchModel = new TipoarchivoSearch();
                                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                                return $this->render('index', ['model' => $buscaEvaluacion,'searchModel' => $searchModel,'dataProvider' => $dataProvider,'items' => $items,]);  
                            }

                        }else{
                            Yii::$app->session->setFlash('error', 'Antes de rechazar una postulación debe revisar y validar todos los documentos adjuntos.');
                            $items=ArrayHelper::map(Estadoevaluacion::find()->all(),'id_estado','descripcion_estado');
                            $searchModel = new TipoarchivoSearch();
                            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                            return $this->render('index', ['model' => $buscaEvaluacion,'searchModel' => $searchModel,'dataProvider' => $dataProvider,'items' => $items,]); 
                        }
                }

                if($buscaEvaluacion->id_estado == 3){
                    if($buscaEvaluacion->puntaje_1 == null){
                        Yii::$app->session->setFlash('error', 'Debe seleccionar un puntaje para aprobar la evaluación.');
                        $items=ArrayHelper::map(Estadoevaluacion::find()->all(),'id_estado','descripcion_estado');
                        $searchModel = new TipoarchivoSearch();
                        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                        return $this->render('index', ['model' => $buscaEvaluacion,'searchModel' => $searchModel,'dataProvider' => $dataProvider,'items' => $items,]);                        
                    }else{
                        
                        $buscaEvaluacionArchivo = EvaluacionArchivo::find()->where(['id_evaluacion'=>$buscaEvaluacion->id_evaluacion])->count();
                        $buscaTiposArchivos = Tipoarchivo::find()->count();
                        $buscaEvaluacionArchivosRevisados = EvaluacionArchivo::find()->where(['and',['id_evaluacion' => $buscaEvaluacion->id_evaluacion],['id_estado' => 3]])->count();
                        $buscaEvaluacionArchivosRevisados2 = EvaluacionArchivo::find()->where(['and',['id_evaluacion' => $buscaEvaluacion->id_evaluacion],['id_estado' => 4]])->count();
                        if(($buscaEvaluacionArchivo == $buscaTiposArchivos) && ($buscaEvaluacionArchivosRevisados + $buscaEvaluacionArchivosRevisados2) == $buscaTiposArchivos){
                            if($buscaEvaluacion->observaciones_1 != null){

                                $buscaFormulario = Formulario::find()->where(['id_postulacion' => $id_postulacion])->one();
                                $numero = (int)$buscaFormulario->numero_beneficiariosDirectos;
                                if($numero >= 500){
                                    $buscaEvaluacion->puntaje_2 = 3;
                                    $buscaEvaluacion->observaciones_2 = 'Se le han asignado 3 puntos debido a que el número de beneficiarios directos de su proyecto es superior o igual a 500 personas.';
                                }else{
                                    if($numero >= 250 && $numero <= 499){
                                        $buscaEvaluacion->puntaje_2 = 2;
                                        $buscaEvaluacion->observaciones_2 = 'Se le han asignado 2 puntos debido a que el número de beneficiarios directos de su proyecto es superior o igual a 250 y menor o igual a 500 personas.';
                                    }else{
                                        if($numero < 250){
                                            $buscaEvaluacion->puntaje_2 = 1;
                                            $buscaEvaluacion->observaciones_2 = 'Se le ha asignado 1 punto debido a que el número de beneficiarios directos de su proyecto es inferior a 250 personas.';
                                        }
                                    }
                                }
                       

                                $aporteTotal = (float)$buscaFormulario->financiamiento_aporteTotal_proyecto;
                                $aporteReq1 = (float)($aporteTotal * 0.2);
                                $aporteReq2 = (float)($aporteTotal * 0.1);
                                $aportePropio = (float)$buscaFormulario->financiamiento_aporte_propio;

                                if($aportePropio >= $aporteReq1){
                                    $buscaEvaluacion->puntaje_3 = 3;
                                    $buscaEvaluacion->observaciones_3 = 'Se le han asignado 3 puntos debido a que el aporte propio es superior al 20% del monto total del proyecto.';
                                }else{
                                    if($aportePropio >= $aporteReq2){
                                        $buscaEvaluacion->puntaje_3 = 2;
                                        $buscaEvaluacion->observaciones_3 = 'Se le han asignado 2 puntos debido a que el aporte propio es superior al 10% del monto total del proyecto.';
                                    }else{
                                        if($aportePropio < $aporteReq2){
                                            $buscaEvaluacion->puntaje_3 = 1;
                                            $buscaEvaluacion->observaciones_3 = 'Se le ha asignado 1 punto debido a que el aporte propio es inferior al 10% del monto total del proyecto.';
                                        }
                                    }
                                }
                                $buscaEvaluacion->etapa = 2;
                                $buscaEvaluacion->save(); 
                            
                                $buscaPostulacion = Postulacion::find()->where(['id_postulacion' => $id_postulacion])->one();
                                $buscaConcursante = Concursante::find()->where(['id_concursante' => $buscaPostulacion->id_concursante])->one();
                                Yii::$app->session->setFlash('success', 'La postulación de '.$buscaConcursante->nombreConcursante.' ha pasado a la etapa de pre-selección.');
                                return Yii::$app->getResponse()->redirect(['/postulacion/evaluacion2']);

                            }else{
                                Yii::$app->session->setFlash('error', 'Antes de aprobar una postulación debe ingresar observaciones.');
                                $items=ArrayHelper::map(Estadoevaluacion::find()->all(),'id_estado','descripcion_estado');
                                $searchModel = new TipoarchivoSearch();
                                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                                return $this->render('index', ['model' => $buscaEvaluacion,'searchModel' => $searchModel,'dataProvider' => $dataProvider,'items' => $items,]);  
                            }


                        }else{
                            Yii::$app->session->setFlash('error', 'No es posible aprobar una postulación si no cumple con los requisitos de documentación.');
                            $items=ArrayHelper::map(Estadoevaluacion::find()->all(),'id_estado','descripcion_estado');
                            $searchModel = new TipoarchivoSearch();
                            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                            return $this->render('index', ['model' => $buscaEvaluacion,'searchModel' => $searchModel,'dataProvider' => $dataProvider,'items' => $items,]); 
                        }
                    }
                }
                $buscaEvaluacion->save();
                Yii::$app->session->setFlash('success', 'Los datos de la evaluación han sido guardados correctamente.');
                return Yii::$app->getResponse()->redirect(['/tipoarchivo/index', 'id_postulacion' => $id_postulacion]);

            }else{

                $items=ArrayHelper::map(Estadoevaluacion::find()->all(),'id_estado','descripcion_estado');
                $searchModel = new TipoarchivoSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                return $this->render('index', ['model' => $buscaEvaluacion,'searchModel' => $searchModel,'dataProvider' => $dataProvider,'items' => $items,]);
            }

    }else{
            throw new NotFoundHttpException('La página solicitada no existe.');
        }

    }else{
        Yii::$app->session->setFlash('error', 'No tienes autorización para ingresar a esta sección.');
        return Yii::$app->getResponse()->redirect(['/site/index']);
    }

        }

    public function actionArchivos()
    {

        if ( (User::isUserAdmin(Yii::$app->user->identity->id) == true) ){

        $request = Yii::$app->request;
        $id_postulacion = $request->get('id_postulacion');

        $buscaPostulacionValidar = Postulacion::find()->where(['id_postulacion' => $id_postulacion ])->one();

        if($buscaPostulacionValidar != null){

        $buscaFormulario = Formulario::find()->where(['id_postulacion' => $id_postulacion])->one();
        $searchModel = new TipoarchivoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('archivos', ['model' => $buscaFormulario,'searchModel' => $searchModel,'dataProvider' => $dataProvider,]); 

    }else{
            throw new NotFoundHttpException('La página solicitada no existe.');
        }

    }else{
        Yii::$app->session->setFlash('error', 'No tienes autorización para ingresar a esta sección.');
        return Yii::$app->getResponse()->redirect(['/site/index']);
    }

    }

}
