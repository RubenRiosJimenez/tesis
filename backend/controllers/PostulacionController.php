<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use backend\models\Postulacion;
use backend\models\Formulario;
use backend\models\Resultado;
use backend\models\Estadoresultado;
use backend\models\Evaluacion;
use backend\models\Convocatoria;
use backend\models\Concursante;
use backend\models\PostulacionSearch;
use backend\models\PostulacionSearchNoAdmin;
use backend\models\PostulacionSearchEvaluacion1;
use backend\models\PostulacionSearchEvaluacion2;
use backend\models\PostulacionSearchEvaluacion3;
use backend\models\Tablaitemfinanciamiento;
use backend\models\Tablapresupuesto;
use backend\models\Tablacartagantt;
use backend\models\Adjunto;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\mpdf\Pdf;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use backend\models\User;


/**
 * PostulacionController implements the CRUD actions for Postulacion model.
 */
class PostulacionController extends Controller
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
                        'actions' => ['index', 'exportarpostulaciones', 'evaluacion1', 'exportarevaluaciones1','mostrardetallepostulacion', 'evaluacion2', 'exportarevaluaciones2', 'seleccionados', 'exportarseleccionados', 'view', 'viewresultados', 'descargarpostulacion', 'cambiarestado', 'preseleccionaevaluacion', 'seleccionapreseleccion','postulacionesnoadmin', 'exportarpostulacionesnoadmin'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'cambiarestado' => ['POST'],
                    'preseleccionaevaluacion' => ['POST'],
                    'seleccionapreseleccion' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Postulacion models.
     * @return mixed
     */
    public function actionIndex()
    {

        if ( (User::isUserAdmin(Yii::$app->user->identity->id) == true) ){

        $model = new Postulacion();
        $searchModel = new PostulacionSearch();
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $params = Yii::$app->request->queryParams;

        if (count($params) <= 1) {
            $params = Yii::$app->session['postulacionparams1'];
            if(isset(Yii::$app->session['postulacionparams1']['page']))
                $_GET['page'] = Yii::$app->session['postulacionparams1']['page'];
        } else {
                Yii::$app->session['postulacionparams1'] = $params;
        }

        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }else{
        Yii::$app->session->setFlash('error', 'No tienes autorización para ingresar a esta sección.');
        return Yii::$app->getResponse()->redirect(['/site/index']);
    }

    }   

    public function actionExportarpostulaciones()
    {

        if ( (User::isUserAdmin(Yii::$app->user->identity->id) == true) ){

        $searchModel = new PostulacionSearch();
        $session = Yii::$app->session;

        $dataProvider = $searchModel->search(Yii::$app->session->get('postulacionparams1')); //restore request here

//fechas
      $dia = array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
      $mes = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre",
                                "Octubre", "Noviembre", "Diciembre");
                                


      date_default_timezone_set('America/Santiago');
      $fecha_actual= getdate();

      if($fecha_actual['minutes']>=0&&$fecha_actual['minutes']<=9){
          $fecha_mostrar= ''.$dia[$fecha_actual['wday']].', '.$fecha_actual['mday'].' de '.$mes[$fecha_actual['mon']-1].' del '.$fecha_actual['year'].' - '.$fecha_actual['hours'].':0'.$fecha_actual['minutes'].' hrs.';


      }else{

          $fecha_mostrar= ''.$dia[$fecha_actual['wday']].', '.$fecha_actual['mday'].' de '.$mes[$fecha_actual['mon']-1].' del '.$fecha_actual['year'].' - '.$fecha_actual['hours'].':'.$fecha_actual['minutes'].' hrs.';

      }
      $fecha_filename= ''.$fecha_actual['mday'].'-'.$fecha_actual['mon'].'-'.$fecha_actual['year'];
 
      $content = $this->renderPartial('postulacionespdf', ['searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
              // set to use core fonts only
        'mode' => Pdf::MODE_CORE, 
        // A4 paper format
        'format' => Pdf::FORMAT_A4, 
        // portrait orientation
     
        // stream to browser inline
       
      ]);

         $pdf = new Pdf([
        'content' => $content,
       'filename' => 'Postulaciones'.$fecha_filename.'.pdf',
            'methods' => [
            'SetFooter' => ['Generado el: ' .$fecha_mostrar],
           // 'SetFooter' => ['|Page {PAGENO}|'],
        ],
         // your html content input
        // format content from your own css file if needed or use the
        // enhanced bootstrap css built by Krajee for mPDF formatting 
        'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
        // any css to be embedded if required
        'cssInline' => '.kv-heading-1{font-size:18px}', 
         // set mPDF properties on the fly
       'options' => ['title' => 'Postulaciones'],
         // call mPDF methods on the fly
      'destination' => Pdf::DEST_DOWNLOAD, 
         'orientation' => Pdf::ORIENT_LANDSCAPE, 
      // 'destination' => Pdf::DEST_BROWSER,
        ]);

        return $pdf->render(); 

    }else{
        Yii::$app->session->setFlash('error', 'No tienes autorización para ingresar a esta sección.');
        return Yii::$app->getResponse()->redirect(['/site/index']);
    }

    }



    public function actionEvaluacion1()
    {

        if ( (User::isUserAdmin(Yii::$app->user->identity->id) == true) ){

        $model = new Postulacion();
        $searchModel = new PostulacionSearchEvaluacion1();
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $params = Yii::$app->request->queryParams;

        if (count($params) <= 1) {
            $params = Yii::$app->session['postulacionparams2'];
            if(isset(Yii::$app->session['postulacionparams2']['page']))
                $_GET['page'] = Yii::$app->session['postulacionparams2']['page'];
        } else {
                Yii::$app->session['postulacionparams2'] = $params;
        }

        $dataProvider = $searchModel->search($params);


        return $this->render('evaluacion1', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }else{
        Yii::$app->session->setFlash('error', 'No tienes autorización para ingresar a esta sección.');
        return Yii::$app->getResponse()->redirect(['/site/index']);
    }

    }

public function actionExportarevaluaciones1()
    {

        if ( (User::isUserAdmin(Yii::$app->user->identity->id) == true) ){

        $searchModel = new PostulacionSearchEvaluacion1();
        $session = Yii::$app->session;

        $dataProvider = $searchModel->search(Yii::$app->session->get('postulacionparams2')); //restore request here

//fechas
      $dia = array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
      $mes = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre",
                                "Octubre", "Noviembre", "Diciembre");
                                


      date_default_timezone_set('America/Santiago');
      $fecha_actual= getdate();
	  if($fecha_actual['minutes']>=0&&$fecha_actual['minutes']<=9){
          $fecha_mostrar= ''.$dia[$fecha_actual['wday']].', '.$fecha_actual['mday'].' de '.$mes[$fecha_actual['mon']-1].' del '.$fecha_actual['year'].' - '.$fecha_actual['hours'].':0'.$fecha_actual['minutes'].' hrs.';


      }else{

          $fecha_mostrar= ''.$dia[$fecha_actual['wday']].', '.$fecha_actual['mday'].' de '.$mes[$fecha_actual['mon']-1].' del '.$fecha_actual['year'].' - '.$fecha_actual['hours'].':'.$fecha_actual['minutes'].' hrs.';

      }

      $fecha_filename= ''.$fecha_actual['mday'].'-'.$fecha_actual['mon'].'-'.$fecha_actual['year'];
 
      $content = $this->renderPartial('evaluaciones1pdf', ['searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
              // set to use core fonts only
        'mode' => Pdf::MODE_CORE, 
        // A4 paper format
        'format' => Pdf::FORMAT_A4, 
        // portrait orientation
        // stream to browser inline
       
      ]);

         $pdf = new Pdf([
        'content' => $content,
       'filename' => 'PostulacionesEnEvaluacion'.$fecha_filename.'.pdf',
            'methods' => [
            'SetFooter' => ['Generado el: ' .$fecha_mostrar],
           // 'SetFooter' => ['|Page {PAGENO}|'],
        ],
   
         // your html content input
        // format content from your own css file if needed or use the
        // enhanced bootstrap css built by Krajee for mPDF formatting 
        'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
        // any css to be embedded if required
        'cssInline' => '.kv-heading-1{font-size:18px}', 
         // set mPDF properties on the fly
       'options' => ['title' => 'PostulacionesEnEvaluacion'],
         // call mPDF methods on the fly
     'destination' => Pdf::DEST_DOWNLOAD, 
       'orientation' => Pdf::ORIENT_LANDSCAPE, 
      //'destination' => Pdf::DEST_BROWSER,
        ]);

        return $pdf->render();

    }else{
        Yii::$app->session->setFlash('error', 'No tienes autorización para ingresar a esta sección.');
        return Yii::$app->getResponse()->redirect(['/site/index']);
    }

    }      

    public function actionEvaluacion2()
    {

        if ( (User::isUserAdmin(Yii::$app->user->identity->id) == true) ){

        $model = new Postulacion();
        $searchModel = new PostulacionSearchEvaluacion2();
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $params = Yii::$app->request->queryParams;

        if (count($params) <= 1) {
            $params = Yii::$app->session['postulacionparams3'];
            if(isset(Yii::$app->session['postulacionparams3']['page']))
                $_GET['page'] = Yii::$app->session['postulacionparams3']['page'];
        } else {
                Yii::$app->session['postulacionparams3'] = $params;
        }

        $dataProvider = $searchModel->search($params);

        return $this->render('evaluacion2', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }else{
        Yii::$app->session->setFlash('error', 'No tienes autorización para ingresar a esta sección.');
        return Yii::$app->getResponse()->redirect(['/site/index']);
    }

    }


public function actionExportarevaluaciones2()
    {

        if ( (User::isUserAdmin(Yii::$app->user->identity->id) == true) ){

$searchModel = new PostulacionSearchEvaluacion2();
        $session = Yii::$app->session;

        $dataProvider = $searchModel->search(Yii::$app->session->get('postulacionparams3')); //restore request here

//fechas
      $dia = array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
      $mes = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre",
                                "Octubre", "Noviembre", "Diciembre");
                                


      date_default_timezone_set('America/Santiago');
      $fecha_actual= getdate();


     if($fecha_actual['minutes']>=0&&$fecha_actual['minutes']<=9){
          $fecha_mostrar= ''.$dia[$fecha_actual['wday']].', '.$fecha_actual['mday'].' de '.$mes[$fecha_actual['mon']-1].' del '.$fecha_actual['year'].' - '.$fecha_actual['hours'].':0'.$fecha_actual['minutes'].' hrs.';


      }else{

          $fecha_mostrar= ''.$dia[$fecha_actual['wday']].', '.$fecha_actual['mday'].' de '.$mes[$fecha_actual['mon']-1].' del '.$fecha_actual['year'].' - '.$fecha_actual['hours'].':'.$fecha_actual['minutes'].' hrs.';

      }
	  
      $fecha_filename= ''.$fecha_actual['mday'].'-'.$fecha_actual['mon'].'-'.$fecha_actual['year'];
 
      $content = $this->renderPartial('evaluaciones2pdf', ['searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
              // set to use core fonts only
        'mode' => Pdf::MODE_CORE, 
        // A4 paper format
        'format' => Pdf::FORMAT_A4, 
        // portrait orientation
        'orientation' => Pdf::ORIENT_PORTRAIT, 
        // stream to browser inline
       
      ]);

         $pdf = new Pdf([
        'content' => $content,
       'filename' => 'PostulacionesPreseleccionadas'.$fecha_filename.'.pdf',
          'methods' => [
            'SetFooter' => ['Generado el: ' .$fecha_mostrar],
           // 'SetFooter' => ['|Page {PAGENO}|'],
        ],
         // your html content input
        // format content from your own css file if needed or use the
        // enhanced bootstrap css built by Krajee for mPDF formatting 
        'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
        // any css to be embedded if required
        'cssInline' => '.kv-heading-1{font-size:18px}', 
         // set mPDF properties on the fly
       'options' => ['title' => 'PostulacionesPreseleccionadas'],
         // call mPDF methods on the fly
     'destination' => Pdf::DEST_DOWNLOAD, 
       'orientation' => Pdf::ORIENT_LANDSCAPE, 
      // 'destination' => Pdf::DEST_BROWSER,
        ]);

        return $pdf->render(); 

    }else{
        Yii::$app->session->setFlash('error', 'No tienes autorización para ingresar a esta sección.');
        return Yii::$app->getResponse()->redirect(['/site/index']);
    }


    }

    public function actionSeleccionados()
    {

        if ( (User::isUserAdmin(Yii::$app->user->identity->id) == true) ){

        $model = new Postulacion();

        $searchModel = new PostulacionSearchEvaluacion3();

        $params = Yii::$app->request->queryParams;

        if (count($params) <= 1) {
            $params = Yii::$app->session['postulacionparams4'];
            if(isset(Yii::$app->session['postulacionparams4']['page']))
                $_GET['page'] = Yii::$app->session['postulacionparams4']['page'];
        } else {
                Yii::$app->session['postulacionparams4'] = $params;
        }

        $dataProvider = $searchModel->search($params);

    if(Yii::$app->request->post('hasEditable'))
    {
        $id_postulacion = Yii::$app->request->post('editableKey');
        $model = Postulacion::findOne($id_postulacion);


        $post = [];
        $posted = current($_POST['Postulacion']);
        $post['Postulacion'] = $posted;

     // Load model like any single model validation
    if ($model->load($post))
    {
      if($model->montoAsignado != null){
        if($model->montoAsignado <= 100000000000){
          if(is_numeric($model->montoAsignado)){
            if($model->montoAsignado >= 0){
              $buscaConvocatoria = Convocatoria::find()->where(['id_convocatoria' => $model->id_convocatoria])->one();
              $buscaMontos= Postulacion::find()->where(['id_convocatoria' => $model->id_convocatoria])->andWhere(['<>','id_postulacion', $model->id_postulacion])->all();
                  $sumaMontos=0;
                  foreach ($buscaMontos as $montos) {
                    $sumaMontos+= $montos->montoAsignado;
                  }
                  $monto_total = ($buscaConvocatoria->montoConvocatoria - $sumaMontos) - $model->montoAsignado;
                  if($monto_total >= 0){

                    if($model->save())
                    {
                      $buscaConcursante = Concursante::find()->where(['id_concursante' => $model->id_concursante])->one();
                      Yii::$app->session->setFlash('success', 'Se le ha asignado un nuevo monto a la postulación de '.$buscaConcursante->nombreConcursante);
                      return Yii::$app->getResponse()->redirect(['/postulacion/seleccionados']);
                    }
                  }else{
                      $out = Json::encode(['message'=>'No hay suficiente dinero para la asignación.']);
                      echo $out;
                      die;
                  }
                }else{
                      $out = Json::encode(['message'=>'El monto ingresado no puede ser un valor negativo.']);
                      echo $out;
                      die;                  
                }
              }else{
                      $out = Json::encode(['message'=>'El monto ingresado debe ser de tipo numérico.']);
                      echo $out;
                      die;
              }
            }else{
                      $out = Json::encode(['message'=>'El monto ingresado es demasiado alto.']);
                      echo $out;
                      die;              
            }
          }else{
                      $out = Json::encode(['message'=>'El monto ingresado no puede estar vacío.']);
                      echo $out;
                      die;
          }
    } 
    // Return AJAX JSON encoded response and exit
    }

        return $this->render('seleccionados', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }else{
        Yii::$app->session->setFlash('error', 'No tienes autorización para ingresar a esta sección.');
        return Yii::$app->getResponse()->redirect(['/site/index']);
    }

    }


public function actionExportarseleccionados()
    {

        if ( (User::isUserAdmin(Yii::$app->user->identity->id) == true) ){

      $searchModel = new PostulacionSearchEvaluacion3();
      $session = Yii::$app->session;

       $dataProvider = $searchModel->search(Yii::$app->session->get('postulacionparams4')); //restore request here

 //fechas
      $dia = array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
      $mes = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre",
                                "Octubre", "Noviembre", "Diciembre");
                                


      date_default_timezone_set('America/Santiago');
      $fecha_actual= getdate();

	  if($fecha_actual['minutes']>=0&&$fecha_actual['minutes']<=9){
          $fecha_mostrar= ''.$dia[$fecha_actual['wday']].', '.$fecha_actual['mday'].' de '.$mes[$fecha_actual['mon']-1].' del '.$fecha_actual['year'].' - '.$fecha_actual['hours'].':0'.$fecha_actual['minutes'].' hrs.';


      }else{

          $fecha_mostrar= ''.$dia[$fecha_actual['wday']].', '.$fecha_actual['mday'].' de '.$mes[$fecha_actual['mon']-1].' del '.$fecha_actual['year'].' - '.$fecha_actual['hours'].':'.$fecha_actual['minutes'].' hrs.';

      }

      $fecha_filename= ''.$fecha_actual['mday'].'-'.$fecha_actual['mon'].'-'.$fecha_actual['year'];
 
      $content = $this->renderPartial('seleccionadospdf', ['searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        // set to use core fonts only
        'mode' => Pdf::MODE_CORE, 
        // A4 paper format
        'format' => Pdf::FORMAT_A4, 
        // portrait orientation
        'orientation' => Pdf::ORIENT_PORTRAIT, 
        // stream to browser inline
       
      ]);

         $pdf = new Pdf([
        'content' => $content,
       'filename' => 'PostulacionesSeleccionadas'.$fecha_filename.'.pdf',
             'methods' => [
            'SetFooter' => ['Generado el: ' .$fecha_mostrar],
           // 'SetFooter' => ['|Page {PAGENO}|'],
        ],
         // your html content input
        // format content from your own css file if needed or use the
        // enhanced bootstrap css built by Krajee for mPDF formatting 
        'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
        // any css to be embedded if required
        'cssInline' => '.kv-heading-1{font-size:18px}', 
         // set mPDF properties on the fly
       'options' => ['title' => 'PostulacionesSeleccionadas'],
         // call mPDF methods on the fly
     'destination' => Pdf::DEST_DOWNLOAD, 
       'orientation' => Pdf::ORIENT_LANDSCAPE, 
      // 'destination' => Pdf::DEST_BROWSER,
        ]);

        return $pdf->render(); 

    }else{
        Yii::$app->session->setFlash('error', 'No tienes autorización para ingresar a esta sección.');
        return Yii::$app->getResponse()->redirect(['/site/index']);
    }

    }               

    /**
     * Displays a single Postulacion model.
     * @param integer $id
     * @return mixed
     */
    public function actionView()
    {

        if ( (User::isUserAdmin(Yii::$app->user->identity->id) == true) ){

        $request = Yii::$app->request;
        $id_postulacion = $request->get('id_postulacion');

        $buscaPostulacionValidar = Postulacion::find()->where(['id_postulacion' => $id_postulacion])->one();

        if($buscaPostulacionValidar != null){

        $buscaEvaluacion = Evaluacion::find()->where(['id_postulacion' => $id_postulacion])->one();
        $buscaResultado = Resultado::find()->where(['id_evaluacion' => $buscaEvaluacion->id_evaluacion])->one();
        $items=ArrayHelper::map(Estadoresultado::find()->all(),'id_estado','descripcion_estado');
        if($buscaResultado == null){
          $nuevoResultado = new Resultado();
          $nuevoResultado->id_evaluacion = $buscaEvaluacion->id_evaluacion;
          $nuevoResultado->id_estado = 1;
          $nuevoResultado->save();
          return $this->render('view', [
                'model' => $nuevoResultado,'items' => $items,
            ]);          
        }else{
          if ($buscaResultado->load(Yii::$app->request->post())) {

            if($buscaResultado->id_estado == 3){
                if($buscaResultado->observaciones != null){
                  $buscaResultado->save();
                  Yii::$app->session->setFlash('success', 'Los datos de la asignación han sido guardados correctamente.');
                  return Yii::$app->getResponse()->redirect(['/postulacion/view', 'id_postulacion' => $id_postulacion]); 
                }else{
                  Yii::$app->session->setFlash('error', 'Debe ingresar observaciones.');
           return $this->render('view', [
                'model' => $buscaResultado,'items' => $items,
            ]);                   
                }
            }


            if($buscaResultado->id_estado == 2){
                if($buscaResultado->observaciones != null){
                    $buscaResultado->save();
                    $buscaEvaluacion->etapa = 3;
                    $buscaEvaluacion->save();
                    $buscaPostulacion = Postulacion::find()->where(['id_postulacion' => $id_postulacion])->one();
                    $buscaConcursante = Concursante::find()->where(['id_concursante' => $buscaPostulacion->id_concursante])->one();
                    Yii::$app->session->setFlash('success', 'La postulación de '.$buscaConcursante->nombreConcursante.' ha pasado a la etapa de seleccionados.');
                    return Yii::$app->getResponse()->redirect(['/postulacion/seleccionados']);
                }else{
                  Yii::$app->session->setFlash('error', 'Debe ingresar observaciones.');
           return $this->render('view', [
                'model' => $buscaResultado,'items' => $items,
            ]);                  
                }
            }else{
              $buscaResultado->save();
            Yii::$app->session->setFlash('success', 'Los datos han sido guardados correctamente.');
            return Yii::$app->getResponse()->redirect(['/postulacion/view', 'id_postulacion' => $id_postulacion]);              
            }
          }else{
           return $this->render('view', [
                'model' => $buscaResultado,'items' => $items,
            ]);             
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

    public function actionViewresultados()
    {

        if ( (User::isUserAdmin(Yii::$app->user->identity->id) == true) ){

        $request = Yii::$app->request;
        $id_postulacion = $request->get('id_postulacion');

        $buscaPostulacionValidar = Postulacion::find()->where(['id_postulacion' => $id_postulacion])->one();

        if($buscaPostulacionValidar != null){

        $buscaEvaluacion = Evaluacion::find()->where(['id_postulacion' => $id_postulacion])->one();
        $buscaResultado = Resultado::find()->where(['id_evaluacion' => $buscaEvaluacion->id_evaluacion])->one();
        return $this->render('viewresultados', [
                'model' => $buscaResultado,
            ]);


    }else{
            throw new NotFoundHttpException('La página solicitada no existe.');
        }

    }else{
        Yii::$app->session->setFlash('error', 'No tienes autorización para ingresar a esta sección.');
        return Yii::$app->getResponse()->redirect(['/site/index']);
    }

    }


    public function actionDescargarpostulacion()
    {

              if ( (User::isUserAdmin(Yii::$app->user->identity->id) == true) ){

        $request = Yii::$app->request;
        $id_postulacion = $request->get('id_postulacion');
        $buscaPostulacion = Postulacion::find()->where(['id_postulacion'=>$id_postulacion])->one();

        if($buscaPostulacion != null){

        $id_postulacionencontrada=$buscaPostulacion->id_postulacion;
        $buscaFormulario = Formulario::find()->where(['id_postulacion' => $id_postulacionencontrada])->one();
        /*$rutTmp = explode( "-", $buscaFormulario->rut_organizacion);
        $buscaFormulario->rut_organizacion = number_format( $rutTmp[0], 0, "", ".") . '-' . $rutTmp[1];
        $rutTmp2 = explode( "-", $buscaFormulario->numeroRut_representanteLegal);
        $buscaFormulario->numeroRut_representanteLegal = number_format( $rutTmp2[0], 0, "", ".") . '-' . $rutTmp2[1];*/  
        //fechas
        $dia = array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
        $mes = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre",
                                "Octubre", "Noviembre", "Diciembre");
                                


        date_default_timezone_set('America/Santiago');
        $fecha_actual= getdate();
      if($fecha_actual['minutes']>=0&&$fecha_actual['minutes']<=9){
          $fecha_mostrar= ''.$dia[$fecha_actual['wday']].', '.$fecha_actual['mday'].' de '.$mes[$fecha_actual['mon']-1].' del '.$fecha_actual['year'].' - '.$fecha_actual['hours'].':0'.$fecha_actual['minutes'].' hrs.';


      }else{

          $fecha_mostrar= ''.$dia[$fecha_actual['wday']].', '.$fecha_actual['mday'].' de '.$mes[$fecha_actual['mon']-1].' del '.$fecha_actual['year'].' - '.$fecha_actual['hours'].':'.$fecha_actual['minutes'].' hrs.';

      }
        /*$rutTmp = explode( "-", $buscaFormulario->rut_organizacion);
        $buscaFormulario->rut_organizacion = number_format( $rutTmp[0], 0, "", ".") . '-' . $rutTmp[1];
        $rutTmp2 = explode( "-", $buscaFormulario->numeroRut_representanteLegal);
        $buscaFormulario->numeroRut_representanteLegal = number_format( $rutTmp2[0], 0, "", ".") . '-' . $rutTmp2[1];*/      
        $content = $this->renderPartial('formulario', ['model' => $buscaFormulario,
              // set to use core fonts only
        'mode' => Pdf::MODE_CORE, 
        // A4 paper format
        'format' => Pdf::FORMAT_A4, 
        // portrait orientation
        'orientation' => Pdf::ORIENT_PORTRAIT, 
        // stream to browser inline
  
      ]);

         $pdf = new Pdf([
        'content' => $content,
        'filename' => 'Formulario'.$buscaFormulario->id_formulario.'.pdf',
        'methods' => [
            'SetFooter' => ['Generado el: ' .$fecha_mostrar],
           // 'SetFooter' => ['|Page {PAGENO}|'],
        ],
       
         // your html content input
        // format content from your own css file if needed or use the
        // enhanced bootstrap css built by Krajee for mPDF formatting 
        'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
        // any css to be embedded if required
        'cssInline' => '.kv-heading-1{font-size:18px}', 
         // set mPDF properties on the fly
        'options' => ['title' => 'Formulario'.$buscaFormulario->id_formulario],
         // call mPDF methods on the fly
       'destination' => Pdf::DEST_DOWNLOAD, 
      // 'destination' => Pdf::DEST_BROWSER,
        ]);

     

        return $pdf->render(); 

    }else{
            throw new NotFoundHttpException('La página solicitada no existe.');
        }


    }else{
        Yii::$app->session->setFlash('error', 'No tienes autorización para ingresar a esta sección.');
        return Yii::$app->getResponse()->redirect(['/site/index']);
    }

    }


    public function actionCambiarestado()
    {

      if ( (User::isUserAdmin(Yii::$app->user->identity->id) == true) ){

        $request = Yii::$app->request;
        $id_postulacion = $request->get('id_postulacion');
        $buscaPostulacion = Postulacion::find()->where(['id_postulacion' => $id_postulacion])->one();

        if($buscaPostulacion != null){

        $buscaConcursante = Concursante::find()->where(['id_concursante' => $buscaPostulacion->id_concursante])->one();

        $model = Formulario::find()->where(['id_postulacion' => $id_postulacion])->one();

        $presupuestoTotal = Tablapresupuesto::find()->where(['id_formulario' => $model->id_formulario])->all();

        $totalPresupuestoProyecto = 0;
        if($presupuestoTotal != null){
            foreach($presupuestoTotal as $totalPresupuesto){
                $totalPresupuestoProyecto = $totalPresupuestoProyecto + $totalPresupuesto->costoTotal;
            }
        }

        $tablapresupuesto= Tablapresupuesto::find()->where(['id_formulario' =>$model->id_formulario])->one();
        $tablaitemfinanciamiento= Tablaitemfinanciamiento::find()->where(['id_formulario' =>$model->id_formulario])->one();
        $tablacartagantt= Tablacartagantt::find()->where(['id_formulario' =>$model->id_formulario])->one();
        $adjuntotipoarchivouno= Adjunto::find()->where(['and',['id_formulario' =>$model->id_formulario],['id_tipoArchivo'=>1]])->all();
        $adjuntotipoarchivodos= Adjunto::find()->where(['and',['id_formulario' =>$model->id_formulario],['id_tipoArchivo'=>2]])->all();
        $adjuntotipoarchivotres= Adjunto::find()->where(['and',['id_formulario' =>$model->id_formulario],['id_tipoArchivo'=>3]])->all();
        $adjuntotipoarchivocuatro= Adjunto::find()->where(['and',['id_formulario' =>$model->id_formulario],['id_tipoArchivo'=>4]])->all();
        $adjuntotipoarchivocinco= Adjunto::find()->where(['and',['id_formulario' =>$model->id_formulario],['id_tipoArchivo'=>5]])->all();
        $adjuntotipoarchivoseis= Adjunto::find()->where(['and',['id_formulario' =>$model->id_formulario],['id_tipoArchivo'=>6]])->all();
        $adjuntotipoarchivosiete= Adjunto::find()->where(['and',['id_formulario' =>$model->id_formulario],['id_tipoArchivo'=>7]])->all();
        $adjuntotipoarchivoocho= Adjunto::find()->where(['and',['id_formulario' =>$model->id_formulario],['id_tipoArchivo'=>8]])->all();
        $adjuntotipoarchivodiez= Adjunto::find()->where(['and',['id_formulario' =>$model->id_formulario],['id_tipoArchivo'=>10]])->all();

        if($model->nombre_organizacion==''||$model->nombre_representanteLegal==''||$model->rut_organizacion==''||$model->telefono_contacto==''||$model->numero_personalidadJuridica==''||$model->numeroRut_representanteLegal==''||$model->fecha_personalidadJuridica==''||$model->domiciolio_representanteLegal==''||$model->organismoQueOtorgo_personalidadJuridica==''||$model->objetivos_generalesOrganizacion==''||$model->financiamiento_organizacion==''||$model->area_subvencion==''||($model->area_subvencion=='Otra'&&$model->otra_subvencion==''||$model->nombre_proyecto==''||$model->numero_beneficiariosDirectos==''||$model->numero_unidadVecinal==''||$model->numero_beneficiariosIndirectos==''||$model->direccion_proyecto==''||$model->descripcion_beneficiariosDirectos==''||$model->objetivos_proyecto==''||$model->descripcion_proyecto==''||$tablapresupuesto==null||$tablaitemfinanciamiento==null||$model->financiamiento_aporte_propio==''||$model->financiamiento_aporte_solicitado==''||$model->financiamiento_aporte_terceros==''||$model->financiamiento_aporteTotal_proyecto==''||$tablacartagantt==null||$adjuntotipoarchivouno==null||$adjuntotipoarchivodos==null||$adjuntotipoarchivotres==null||$adjuntotipoarchivocuatro==null||$adjuntotipoarchivocinco==null||$adjuntotipoarchivoseis==null||$adjuntotipoarchivosiete==null||$adjuntotipoarchivoocho==null || $adjuntotipoarchivodiez==null))
        {
          Yii::$app->session->setFlash('error', 'No se puede cambiar el estado a la potulación de '.$buscaConcursante->nombreConcursante.' debido a que no ha completado el formulario de postulación.');
          return Yii::$app->getResponse()->redirect(['/postulacion/index']);

        }else{

            if($totalPresupuestoProyecto == $model->financiamiento_aporteTotal_proyecto){

        $buscaEvaluacion = Evaluacion::find()->where(['id_postulacion' => $id_postulacion])->one();
            if($buscaEvaluacion == null){
                $evaluacion = new Evaluacion();
                $evaluacion->id_postulacion = $id_postulacion;
                $evaluacion->id_estado = 1;
                $evaluacion->etapa = 1;
                $evaluacion->save();
            }
        if($buscaPostulacion->id_estadopostulacion == 1){
          $buscaPostulacion->id_estadopostulacion = 2;
          $buscaPostulacion->save();
        }else{
          $buscaPostulacion->id_estadopostulacion = 1;
          $buscaPostulacion->save();
        }

          Yii::$app->session->setFlash('success', 'Se le ha cambiado el estado a la postulación de '.$buscaConcursante->nombreConcursante);
          return Yii::$app->getResponse()->redirect(['/postulacion/index']);

        }else{
          Yii::$app->session->setFlash('error', 'No se puede cambiar el estado a la potulación de '.$buscaConcursante->nombreConcursante.' debido a que no ha completado el formulario de postulación.');
          return Yii::$app->getResponse()->redirect(['/postulacion/index']);
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

    public function actionPreseleccionaevaluacion()
    {
              if ( (User::isUserAdmin(Yii::$app->user->identity->id) == true) ){

        $request = Yii::$app->request;
        $id_postulacion = $request->get('id_postulacion');
        $buscaPostulacion = Postulacion::find()->where(['id_postulacion' => $id_postulacion])->one();

        if($buscaPostulacion != null){

        $buscaConcursante = Concursante::find()->where(['id_concursante' => $buscaPostulacion->id_concursante])->one();
        $buscaEvaluacion = Evaluacion::find()->where(['id_postulacion' => $id_postulacion])->one();
        $buscaResultado = Resultado::find()->where(['id_evaluacion' => $buscaEvaluacion->id_evaluacion])->one();
        if($buscaResultado != null){
          $buscaResultado->delete();
        }
        $buscaEvaluacion->etapa = 1;
        $buscaEvaluacion->puntaje_2 = null;
        $buscaEvaluacion->puntaje_3 = null;
        $buscaEvaluacion->observaciones_2 = null;
        $buscaEvaluacion->observaciones_3 = null;
        $buscaEvaluacion->id_estado = 1;
        $buscaEvaluacion->save();

          Yii::$app->session->setFlash('success', 'La postulación de '.$buscaConcursante->nombreConcursante.' regresó a la etapa de evaluación.');
          return Yii::$app->getResponse()->redirect(['/postulacion/evaluacion1']);

    }else{
            throw new NotFoundHttpException('La página solicitada no existe.');
        }

    }else{
        Yii::$app->session->setFlash('error', 'No tienes autorización para ingresar a esta sección.');
        return Yii::$app->getResponse()->redirect(['/site/index']);
    }

    }

    public function actionSeleccionapreseleccion()
    {

                    if ( (User::isUserAdmin(Yii::$app->user->identity->id) == true) ){
        $request = Yii::$app->request;
        $id_postulacion = $request->get('id_postulacion');
        $buscaPostulacion = Postulacion::find()->where(['id_postulacion' => $id_postulacion])->one();

        if($buscaPostulacion != null){

        $buscaConcursante = Concursante::find()->where(['id_concursante' => $buscaPostulacion->id_concursante])->one();
        $buscaEvaluacion = Evaluacion::find()->where(['id_postulacion' => $id_postulacion])->one();
        $buscaResultado = Resultado::find()->where(['id_evaluacion' => $buscaEvaluacion->id_evaluacion])->one();
        $buscaEvaluacion->etapa = 2;
        $buscaEvaluacion->save();
        $buscaResultado->id_estado = 1;
        $buscaResultado->save();
        $buscaPostulacion->montoAsignado = null;
        $buscaPostulacion->save();

          Yii::$app->session->setFlash('success', 'La postulación de '.$buscaConcursante->nombreConcursante.' regresó a la etapa de pre-selección.');
          return Yii::$app->getResponse()->redirect(['/postulacion/evaluacion2']);

    }else{
            throw new NotFoundHttpException('La página solicitada no existe.');
        }

    }else{
        Yii::$app->session->setFlash('error', 'No tienes autorización para ingresar a esta sección.');
        return Yii::$app->getResponse()->redirect(['/site/index']);
    }

    }


public function actionPostulacionesnoadmin()
    {

        if ( (User::isUserAlcalde(Yii::$app->user->identity->id) == true) || (User::isUserSecretaria(Yii::$app->user->identity->id) == true) ){

        $model = new Postulacion();
        $searchModel = new PostulacionSearchNoAdmin();

        $params = Yii::$app->request->queryParams;

        if (count($params) <= 1) {
            $params = Yii::$app->session['postulacionparams5'];
            if(isset(Yii::$app->session['postulacionparams5']['page']))
                $_GET['page'] = Yii::$app->session['postulacionparams5']['page'];
        } else {
                Yii::$app->session['postulacionparams5'] = $params;
        }

        $dataProvider = $searchModel->search($params);

      

        return $this->render('postulacionesnoadmin', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }else{
        Yii::$app->session->setFlash('error', 'No tienes autorización para ingresar a esta sección.');
        return Yii::$app->getResponse()->redirect(['/site/index']);
    }

    }    

    public function actionExportarpostulacionesnoadmin()
    {

        if ( (User::isUserAlcalde(Yii::$app->user->identity->id) == true) || (User::isUserSecretaria(Yii::$app->user->identity->id) == true) ){

$searchModel = new PostulacionSearchNoAdmin();
        $session = Yii::$app->session;

        $dataProvider = $searchModel->search(Yii::$app->session->get('postulacionparams5')); //restore request here

//fechas
      $dia = array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
      $mes = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre",
                                "Octubre", "Noviembre", "Diciembre");
                                


      date_default_timezone_set('America/Santiago');
      $fecha_actual= getdate();

	  if($fecha_actual['minutes']>=0&&$fecha_actual['minutes']<=9){
          $fecha_mostrar= ''.$dia[$fecha_actual['wday']].', '.$fecha_actual['mday'].' de '.$mes[$fecha_actual['mon']-1].' del '.$fecha_actual['year'].' - '.$fecha_actual['hours'].':0'.$fecha_actual['minutes'].' hrs.';


      }else{

          $fecha_mostrar= ''.$dia[$fecha_actual['wday']].', '.$fecha_actual['mday'].' de '.$mes[$fecha_actual['mon']-1].' del '.$fecha_actual['year'].' - '.$fecha_actual['hours'].':'.$fecha_actual['minutes'].' hrs.';

      }
      $fecha_filename= ''.$fecha_actual['mday'].'-'.$fecha_actual['mon'].'-'.$fecha_actual['year'];
 
      $content = $this->renderPartial('postulacionesnoadminpdf', ['searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
              // set to use core fonts only
        'mode' => Pdf::MODE_CORE, 
        // A4 paper format
        'format' => Pdf::FORMAT_A4, 
        // portrait orientation
     
        // stream to browser inline
       
      ]);

         $pdf = new Pdf([
        'content' => $content,
       'filename' => 'Postulaciones'.$fecha_filename.'.pdf',
            'methods' => [
            'SetFooter' => ['Generado el: ' .$fecha_mostrar],
           // 'SetFooter' => ['|Page {PAGENO}|'],
        ],
         // your html content input
        // format content from your own css file if needed or use the
        // enhanced bootstrap css built by Krajee for mPDF formatting 
        'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
        // any css to be embedded if required
        'cssInline' => '.kv-heading-1{font-size:18px}', 
         // set mPDF properties on the fly
       'options' => ['title' => 'Postulaciones'],
         // call mPDF methods on the fly
      'destination' => Pdf::DEST_DOWNLOAD, 
         'orientation' => Pdf::ORIENT_LANDSCAPE, 
      // 'destination' => Pdf::DEST_BROWSER,
        ]);

        return $pdf->render();

    }else{
        Yii::$app->session->setFlash('error', 'No tienes autorización para ingresar a esta sección.');
        return Yii::$app->getResponse()->redirect(['/site/index']);
    }

    }

    public function actionMostrardetallepostulacion()
    {
        $request = Yii::$app->request;
        $id_convocatoria = $request->get('id_convocatoria');
        $id_postulacion= $request->get('id_postulacion');
        //$buscaConvocatoria = Convocatoria::find()->where(['and',['id_convocatoria' => $id_convocatoria],['id_estadoConvocatoria' => 3]])->one();
        $buscaPostulacion = Postulacion::find()->where(['and',['id_convocatoria' => $id_convocatoria],['id_postulacion' => $id_postulacion]])->one();

        if($buscaPostulacion != null){

        $buscaEvaluacion = Evaluacion::find()->where(['id_postulacion' => $id_postulacion])->one();
        $buscaResultado = Resultado::find()->where(['id_evaluacion' => $buscaEvaluacion->id_evaluacion])->one();

        if($buscaResultado==false){
              return $this->render('detallepostulacion2', [
                'model' => $buscaEvaluacion,
            ]);     
    

        }else{
            if($buscaResultado->id_estado == 2){
                return $this->render('detallepostulacion', [
                'model' => $buscaResultado,
                ]);
            }else{
                return $this->render('detallepostulacion3', [
                'model' => $buscaResultado,
                ]);
            }     
    

        }
         }else{
            throw new NotFoundHttpException('La página solicitada no existe.');
    } 

    }




}
