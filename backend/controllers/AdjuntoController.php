<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use backend\models\Tipoarchivo;
use backend\models\Adjunto;
use backend\models\AdjuntoSearch;
use backend\models\TipoarchivoSearch;
use backend\models\Formulario;
use backend\models\Postulacion;
use backend\models\Evaluacionarchivo;
use backend\models\Evaluacion;
use backend\models\Estadoevaluacionarchivo;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use lavrentiev\widgets\toastr\Notification;
use yii\helpers\ArrayHelper;
use backend\models\User;

/**
 * AdjuntoController implements the CRUD actions for Adjunto model.
 */
class AdjuntoController extends Controller
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
                        'actions' => ['index', 'documentacion', 'view', 'download'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Adjunto models.
     * @return mixed
     */
    public function actionIndex()
    {

        if ( (User::isUserAdmin(Yii::$app->user->identity->id) == true) ){



        $request = Yii::$app->request;
        $id_tipoArchivo=$request->get('id_tipoArchivo');
        $id_postulacion = $request->get('id_postulacion');

        $buscaPostulacionValidar = Postulacion::find()->where(['id_postulacion' => $id_postulacion])->one();
        $buscaTipoArchivoValidar = Tipoarchivo::find()->where(['id_tipoArchivo' => $id_tipoArchivo])->one();

        if($buscaPostulacionValidar != null && $buscaTipoArchivoValidar != null){


        $buscaFormulario = Formulario::find()->where(['id_postulacion' => $id_postulacion])->one();
        $id_formulario=$buscaFormulario->id_formulario;

        $buscaEvaluacion = Evaluacion::find()->where(['id_postulacion' => $id_postulacion])->one();
        $buscaEvaluacionArchivo = Evaluacionarchivo::find()->where(['and',['id_evaluacion' => $buscaEvaluacion->id_evaluacion],['id_tipoArchivo' => $id_tipoArchivo]])->one();
        if($buscaEvaluacionArchivo == null){
            $model = new Evaluacionarchivo();
            $model->id_evaluacion = $buscaEvaluacion->id_evaluacion;
            $model->id_tipoArchivo = $id_tipoArchivo;
            $model->id_estado = 1;
            $model->save();
            $searchModel = new AdjuntoSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $items=ArrayHelper::map(Estadoevaluacionarchivo::find()->all(),'id_estado','descripcion_estado');
            $dataProvider->query->where(['and',['id_tipoArchivo' => $id_tipoArchivo],['id_formulario' => $id_formulario]])->one();
            $dataProvider->pagination->pageSize=1000;
            return $this->renderAjax('index', ['model' => $model,'searchModel' => $searchModel,'dataProvider' => $dataProvider,'items' => $items,]); 
        }else{
            if ($buscaEvaluacionArchivo->load(Yii::$app->request->post())) {
                if($buscaEvaluacionArchivo->id_estado != 4){

                $buscaEvaluacionArchivo->save();    

                Yii::$app->session->setFlash('success', 'La revisión del documento se ha guardado correctamente.');
                return Yii::$app->getResponse()->redirect(['/tipoarchivo/index', 'id_postulacion' => $id_postulacion]);

                }else{
                    if($buscaEvaluacionArchivo->observaciones == null){
                        Yii::$app->session->setFlash('error', 'Si eligió la opción de "Cumple requisitos con observaciones" debe escribir observaciones.');
                        return Yii::$app->getResponse()->redirect(['/tipoarchivo/index', 'id_postulacion' => $id_postulacion]);
                    }else{
                        $buscaEvaluacionArchivo->save();
                        Yii::$app->session->setFlash('success', 'La revisión del documento se ha guardado correctamente.');
                        return Yii::$app->getResponse()->redirect(['/tipoarchivo/index', 'id_postulacion' => $id_postulacion]);
                    }
                }
            }else{
                $searchModel = new AdjuntoSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                $dataProvider->query->where(['and',['id_tipoArchivo' => $id_tipoArchivo],['id_formulario' => $id_formulario]])->one();
                $items=ArrayHelper::map(Estadoevaluacionarchivo::find()->all(),'id_estado','descripcion_estado');
                $dataProvider->pagination->pageSize=100;
                return $this->renderAjax('index', ['model' => $buscaEvaluacionArchivo,'searchModel' => $searchModel,'dataProvider' => $dataProvider,'items' => $items,]); 
            }

        }

    }else{
            throw new NotFoundHttpException('La página solicitada no existe.');
        }

    }else{
        Yii::$app->session->setFlash('error', 'No tienes autorización para ingresar a esta sección.');
        return Yii::$app->getResponse()->redirect(['/site/index']);
    }

}

        public function actionDocumentacion()
    {

        if ( (User::isUserAdmin(Yii::$app->user->identity->id) == true) ){

        $request = Yii::$app->request;
        $id_tipoArchivo=$request->get('id_tipoArchivo');
        $id_postulacion = $request->get('id_postulacion');

        $buscaPostulacionValidar = Postulacion::find()->where(['id_postulacion' => $id_postulacion])->one();
        $buscaTipoArchivoValidar = Tipoarchivo::find()->where(['id_tipoArchivo' => $id_tipoArchivo])->one();

        if($buscaPostulacionValidar != null && $buscaTipoArchivoValidar != null){

        $buscaFormulario = Formulario::find()->where(['id_postulacion' => $id_postulacion])->one();
        $id_formulario=$buscaFormulario->id_formulario;
        $searchModel = new AdjuntoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->where(['and',['id_tipoArchivo' => $id_tipoArchivo],['id_formulario' => $id_formulario]])->one();
        $dataProvider->pagination->pageSize=1000;
        return $this->renderAjax('documentacion', ['model' => $buscaFormulario,'searchModel' => $searchModel,'dataProvider' => $dataProvider,]);


    }else{
            throw new NotFoundHttpException('La página solicitada no existe.');
        }

    }else{
        Yii::$app->session->setFlash('error', 'No tienes autorización para ingresar a esta sección.');
        return Yii::$app->getResponse()->redirect(['/site/index']);
    }


    }

        public function actionDownload()
    {

        if ( (User::isUserAdmin(Yii::$app->user->identity->id) == true) ){

        $request = Yii::$app->request;
        $id_adjunto=$request->get('id_adjunto');
        $model = $this->findModel($id_adjunto);

        if($model != null){

        $path = './../../frontend/web/uploads';

        $file = $path . '/'.$model->nombre_archivo;

        if (file_exists($file)) {

            Yii::$app->response->sendFile($file);

        }else{
            Yii::$app->session->setFlash('error', 'El archivo que intentas descargar no existe.');
            return Yii::$app->getResponse()->redirect(['/tipoarchivo/archivos']);            
        } 


    }else{
            throw new NotFoundHttpException('La página solicitada no existe.');
        }

        }else{
            Yii::$app->session->setFlash('error', 'No tienes autorización para ingresar a esta sección.');
            return Yii::$app->getResponse()->redirect(['/site/index']);
        }

    }
    /**
     * Finds the Adjunto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Adjunto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Adjunto::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('La página solicitada no existe.');
        }
    }
}
