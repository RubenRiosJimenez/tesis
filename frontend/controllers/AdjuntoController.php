<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Tipoarchivo;
use frontend\models\Adjunto;
use frontend\models\AdjuntoSearch;
use frontend\models\TipoarchivoSearch;
use frontend\models\Formulario;
use frontend\models\Concursante;
use frontend\models\Postulacion;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use lavrentiev\widgets\toastr\Notification;
use yii\filters\AccessControl;

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
                        'actions' => ['index', 'create', 'delete', 'download'],
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
     * Lists all Adjunto models.
     * @return mixed
     */
    public function actionIndex()
    {
        $id_usuario_actual=\Yii::$app->user->id;
        $buscaConcursante = Concursante::find()->where(['id' => $id_usuario_actual])->one();
        $request = Yii::$app->request;
        $id_tipoArchivo=$request->get('id_tipoArchivo');
        $id_postulacion = $request->get('id_postulacion');
        $buscaPostulacion = Postulacion::find()->where(['and',['id_postulacion' => $id_postulacion],['id_concursante' => $buscaConcursante->id_concursante]])->one();
        $buscatipoArchivo = Tipoarchivo::find()->where(['id_tipoArchivo' => $id_tipoArchivo])->one();
        if($buscaPostulacion != null && $buscatipoArchivo != null){
            $buscaFormulario = Formulario::find()->where(['id_postulacion' => $id_postulacion])->one();
            $id_formulario=$buscaFormulario->id_formulario;
            $searchModel = new AdjuntoSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->query->where(['and',['id_tipoArchivo' => $id_tipoArchivo],['id_formulario' => $id_formulario]])->one();
            $dataProvider->pagination->pageSize=1000;
            return $this->renderAjax('index', ['model' => $buscaFormulario,'searchModel' => $searchModel,'dataProvider' => $dataProvider,]);
        }else{
            throw new NotFoundHttpException('La página solicitada no existe.');
        }  
    }

    /**
     * Creates a new Adjunto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $id_usuario_actual=\Yii::$app->user->id;
        $buscaConcursante = Concursante::find()->where(['id' => $id_usuario_actual])->one();

        $request = Yii::$app->request;
        $id_tipoArchivo=$request->get('id_tipoArchivo');
        $id_postulacion = $request->get('id_postulacion');


        $buscaPostulacion = Postulacion::find()->where(['and',['id_postulacion' => $id_postulacion],['id_concursante' => $buscaConcursante->id_concursante]])->one();

        $buscatipoArchivo = Tipoarchivo::find()->where(['id_tipoArchivo' => $id_tipoArchivo])->one();
        if($buscaPostulacion != null && $buscatipoArchivo != null){

        $buscaFormulario = Formulario::find()->where(['id_postulacion' => $id_postulacion])->one();

        $searchModel = new TipoarchivoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        $model = new Adjunto();

        if ($model->load(Yii::$app->request->post())){
            $model->archivo=UploadedFile::getInstances($model,'archivo');

            foreach ($model->archivo as $archivo) {
                $model2 = new Adjunto();
                $model2->fileName = $archivo->name;
                $ext = end((explode('.',$archivo->name)));
                $model2->nombre_original = $archivo->name;
                $model2->id_tipoArchivo = $id_tipoArchivo;
                $model2->nombre_archivo = Yii::$app->security->generateRandomString().'.'.$ext;
                $model2->fecha_subida = date("Y-m-d");
                $model2->id_formulario = $buscaFormulario->id_formulario;
                $path = $model2->getArchivo();
                $archivo->saveAs($path);
                if(file_exists($path)){
                    $model2->save();
                }else{
                    return $this->redirect(['/site/section7', 'id_postulacion' => $id_postulacion]);   
                }
            }
                return $this->redirect(['/site/section7', 'id_postulacion' => $id_postulacion]);  
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
     * Deletes an existing Adjunto model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete()
    {
        $id_usuario_actual=\Yii::$app->user->id;
        $buscaConcursante = Concursante::find()->where(['id' => $id_usuario_actual])->one();
        $request = Yii::$app->request;
        $id_adjunto=$request->get('id_adjunto');
        $id_postulacion = $request->get('id_postulacion');

        $buscaPostulacion = Postulacion::find()->where(['and',['id_postulacion' => $id_postulacion],['id_concursante' => $buscaConcursante->id_concursante]])->one();
        $model = $this->findModel($id_adjunto);
        if($buscaPostulacion != null && $model != null){

        $path = Yii::getAlias('@webroot') . '/uploads';
        $file = $path . '/'.$model->nombre_archivo;

        if (file_exists($file)) {
            unlink($path.'/'.$model->nombre_archivo);
            $this->findModel($id_adjunto)->delete();
            return $this->redirect(['/site/section7', 'id_postulacion' => $id_postulacion]);
        }else{
            //Yii::$app->session->setFlash('error', 'No se ha podido eliminar el archivo.');
            return $this->redirect(['/site/section7', 'id_postulacion' => $id_postulacion]);
        }

        }else{
            throw new NotFoundHttpException('La página solicitada no existe.');
        }
    }

        public function actionDownload()
    {

        $id_usuario_actual=\Yii::$app->user->id;
        $buscaConcursante = Concursante::find()->where(['id' => $id_usuario_actual])->one();

        $request = Yii::$app->request;
        $id_adjunto=$request->get('id_adjunto');
        $id_postulacion = $request->get('id_postulacion');

        $buscaPostulacion = Postulacion::find()->where(['and',['id_postulacion' => $id_postulacion],['id_concursante' => $buscaConcursante->id_concursante]])->one();

        $model = $this->findModel($id_adjunto);
        if($buscaPostulacion != null && $model != null){

        $path = Yii::getAlias('@webroot') . '/uploads';

        $file = $path . '/'.$model->nombre_archivo;

        if (file_exists($file)) {

            Yii::$app->response->sendFile($file);

        }else{
            return $this->redirect(['/site/section7', 'id_postulacion' => $id_postulacion]); 
        }

        }else{
            throw new NotFoundHttpException('La página solicitada no existe.');
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
