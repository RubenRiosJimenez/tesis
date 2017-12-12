<?php
namespace frontend\controllers;

use Yii;
use frontend\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\Modificaruser;
use frontend\models\SignupForm;
use frontend\models\Tipoconcursante;
use frontend\models\TipoconcursanteSearch;
use frontend\models\Concursante;
use frontend\models\ConcursanteSearch;
use frontend\models\Convocatoria;
use frontend\models\ConvocatoriaSearch;
use frontend\models\Estadoconvocatoria;
use frontend\models\EstadoconvocatoriaSearch;
use frontend\models\Noticia;
use frontend\models\User;
use frontend\models\Postulacion;
use frontend\models\Resultado;
use frontend\models\PostulacionSearch;
use frontend\models\PostulacionSearch2;
use frontend\models\ContactForm;
use frontend\models\Formulario;
use frontend\models\TablaitemfinanciamientoSearch;
use frontend\models\Tablaitemfinanciamiento;
use frontend\models\TablapresupuestoSearch;
use frontend\models\Tablapresupuesto;
use frontend\models\Tablacartagantt;
use frontend\models\TablacartaganttSearch;
use frontend\models\Adjunto;
use frontend\models\AdjuntoSearch;
use frontend\models\TipoarchivoSearch;
use frontend\models\Evaluacion;
use yii\base\InvalidParamException;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\base\ErrorException;
use yii\web\NotFoundHttpException;
use lavrentiev\widgets\toastr\Notification;
use kartik\mpdf\Pdf;

use yii\helpers\ArrayHelper;
//use kartik\widgets\Growl;


/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public $id_convocatoria;
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['signup','request-password-reset','reset-password','login'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index','contact','resultados', 'subcat','preguntasfrecuentes','bases','error','captcha'],
                        'allow' => true,
                    ],                    
                    [
                        'actions' => ['subcat','logout','datospersonales','mipostulacion','guardarpostulacion','convocatoria','postular','section1','section2','section3','section4','section5','section6','section7','section8','descargarborrador','descargarpostulacion','mostrardetallepostulacion'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $pepito = 1;
        $buscaNoticia = Noticia::find()->where(['id_noticia' => 2])->one();
        return $this->render('index', [
            'model' => $buscaNoticia,
            'pepito' => $pepito
        ]);
    }



    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {         
            return $this->goHome();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

public function actionContact()
    {

        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $administradores= User::find()->where(['role'=>1])->all();

            foreach ($administradores as $copia) {

                $model->sendEmail(Yii::$app->params['adminEmail'],$copia->email); 
            }
           
            Yii::$app->session->setFlash('success', 'Gracias por contactarse con nosotros, le responderemos en breves momentos.');
         return Yii::$app->getResponse()->redirect(['/site/contact']);
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionSignup()
    {

        $tipoConcursante = new Tipoconcursante();
        $items=ArrayHelper::map(Tipoconcursante::find()->all(),'id_tipoConcursante','nombreTipo');
        $model = new SignupForm();
        $concursante = new Concursante();
        if ($model->load(Yii::$app->request->post()) && $concursante->load(Yii::$app->request->post())) {
            if($concursante->validate()){
                if ($user = $model->signup($concursante->nombreConcursante, $concursante->telefono)) {
                    $concursante->id=$user->id;
                    $concursante->save();
                    if (Yii::$app->getUser()->login($user)) {                       
                         return $this->goHome();
                    }
                }
            }
        }
        return $this->render('signup', [
            'model' => $model,'concursante' => $concursante, 'tipoConcursante' => $tipoConcursante, 'items' => $items,
        ]);
    }

    public function actionDatospersonales()
    {
        $id_usuario__actual=\Yii::$app->user->id;
        $tipoConcursante = new Tipoconcursante();
        $items=ArrayHelper::map(Tipoconcursante::find()->all(),'id_tipoConcursante','nombreTipo');
        $concursante = Concursante::find()->where(['id'=>$id_usuario__actual])->one();
        $model = new Modificaruser();
        $usuario= User::find()->where(['id'=>$id_usuario__actual])->one();

        if($usuario != null && $concursante != null){
            $model->email = $usuario->email;
            $model->phone = $usuario->phone;
            if ($model->load(Yii::$app->request->post()) && $concursante->load(Yii::$app->request->post()) ) {
                if($user = $model->updateuser($id_usuario__actual)){
                    $concursante->telefono = $model->phone;
                    $concursante->save();
                    Yii::$app->getSession()->setFlash('success', 'Tus datos personales han sido guardados correctamente.');
                    return Yii::$app->getResponse()->redirect(['/site/datospersonales']);
                }else{
                    return $this->render('datospersonales', [
                    'model' => $model, 'concursante' => $concursante, 'tipoConcursante' => $tipoConcursante, 'items' => $items,
                    ]);
                }
            }else{
                    return $this->render('datospersonales', [
                    'model' => $model, 'concursante' => $concursante, 'tipoConcursante' => $tipoConcursante, 'items' => $items,
                    ]);
            }

        }else{
            throw new NotFoundHttpException('La página solicitada no existe.');
        }
    }




    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Revisa tu email para continuar con el proceso de recuperación de contraseña.');

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Lo siento, no se ha podido llevar a cabo la recuperación de contraseña.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'Su nueva contraseña ha sido guardada con éxito.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }





    public function actionMipostulacion()
    {

        $id_usuario__actual=\Yii::$app->user->id;
        $model = new Postulacion();
        $searchModel = new PostulacionSearch();
        $concursante_actual= Concursante::find()->where(['id' =>$id_usuario__actual])->one();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->where(['and',['postulacion.id_concursante' => $concursante_actual->id_concursante],['>','postulacion.id_estadopostulacion', 1]])->one();

        return $this->render('mipostulacion', ['model' => $model,'searchModel' => $searchModel,'dataProvider' => $dataProvider,]);

    }

    public function actionGuardarpostulacion(){

        $id_usuario_actual=\Yii::$app->user->id;
        $buscaConcursante = Concursante::find()->where(['id' => $id_usuario_actual])->one();

        $request = Yii::$app->request;
        $id_postulacion = $request->get('id_postulacion');

        $buscaPostulacion = Postulacion::find()->where(['and',['id_postulacion' => $id_postulacion],['id_concursante' => $buscaConcursante->id_concursante]])->one();

        if($buscaPostulacion != null){

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
                throw new NotFoundHttpException('La página solicitada no existe.');
        }else{

            if($totalPresupuestoProyecto == $model->financiamiento_aporteTotal_proyecto){

            $buscaPostulacion->fecha_postulacion= date("Y-m-d");
            $buscaPostulacion->id_estadopostulacion = 2;
            $buscaPostulacion->save();

            $id_usuario__actual=\Yii::$app->user->id;
            $concursante_actual= Concursante::find()->where(['id' =>$id_usuario__actual])->one();
            $buscaEvaluacion = Evaluacion::find()->where(['id_postulacion' => $id_postulacion])->one();
            if($buscaEvaluacion == null){
                $evaluacion = new Evaluacion();
                $evaluacion->id_postulacion = $id_postulacion;
                $evaluacion->id_estado = 1;
                $evaluacion->etapa = 1;
                $evaluacion->save();
            }
            Yii::$app->session->setFlash('success', 'Su postulación ha sido enviada correctamente.');
            return Yii::$app->getResponse()->redirect(['/site/mipostulacion', 'id_postulacion' => $id_postulacion]);
            }else{
                throw new NotFoundHttpException('La página solicitada no existe.');
            }
        }


    }else{
            throw new NotFoundHttpException('La página solicitada no existe.');
        }  
    } 


    public function actionConvocatoria()

    {
        $model = new Convocatoria();
        $searchModel = new ConvocatoriaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->where(['id_estadoConvocatoria' => 1])->one();

        return $this->render('convocatoria', ['model' => $model,'searchModel' => $searchModel,'dataProvider' => $dataProvider,]);


    }

    public function actionPostular($id_convocatoria)
    {
        $request = Yii::$app->request;
        $id_convocatoria = $request->get('id_convocatoria');
        $this->id_convocatoria=$id_convocatoria;
        $id_usuario__actual=\Yii::$app->user->id;
        $concursante_actual= Concursante::find()->where(['id' =>$id_usuario__actual])->one();
        $obtieneid_concursante=$concursante_actual->id_concursante;
        $buscaConvocatoria = Convocatoria::find()->where(['id_convocatoria' => $id_convocatoria])->one();
        if($buscaConvocatoria != null && $buscaConvocatoria->id_estadoConvocatoria == 1){
            $buscaPostulacion = Postulacion::find()->where(['and',['id_convocatoria' => $id_convocatoria],['id_concursante' => $obtieneid_concursante]])->one();

            if($buscaPostulacion==null){//si no existe una postulacion
                $postulacion = new Postulacion();
                $postulacion->id_convocatoria=$id_convocatoria;
                $postulacion->id_concursante=$obtieneid_concursante;
                $postulacion->id_estadopostulacion=1;//le asigno el estado de postulacion no enviada
                $postulacion->save();//guardo la postulacion

                $buscaPostulacionGuardadaRecientemente = Postulacion::find()->where(['and',['id_convocatoria' => $id_convocatoria],['id_concursante'=>  $obtieneid_concursante]])->one(); 
                $id_postulacionGuardadaRecientemente=$buscaPostulacionGuardadaRecientemente->id_postulacion;


                $model= new Formulario();
                $model->id_postulacion=$id_postulacionGuardadaRecientemente;//se asocia el formulario a esa postulacion

                $model->fecha_personalidadJuridica= date("Y-m-d");

                $model->save();
                return $this->redirect(['section1', 'id_postulacion' => $model->id_postulacion]);

            }else{//si existe una postulacion
                $id_postulacionencontrada=$buscaPostulacion->id_postulacion;
                $buscaFormulario = Formulario::find()->where(['id_postulacion' => $id_postulacionencontrada])->one();
                return $this->redirect(['section1', 'id_postulacion' => $buscaFormulario->id_postulacion]);
            
            }
        }else{
            throw new NotFoundHttpException('La página solicitada no existe.');
        }
    }

    
    public function actionSection1()//es el mismo procedimiento para los section 1,2 y 3 solo cambia la vista a la cual es renderizada el modelo
    {

        $id_usuario_actual=\Yii::$app->user->id;
        $buscaConcursante = Concursante::find()->where(['id' => $id_usuario_actual])->one();

        $request = Yii::$app->request;
        $id_postulacion = $request->get('id_postulacion');

        $buscaPostulacion = Postulacion::find()->where(['and',['id_postulacion' => $id_postulacion],['id_concursante' => $buscaConcursante->id_concursante]])->one();

        if($buscaPostulacion != null){

        $buscaFormulario = Formulario::find()->where(['id_postulacion' => $id_postulacion])->one();
        if($buscaFormulario->load(Yii::$app->request->post())){



                $buscaFormulario->fecha_personalidadJuridica= date('Y-m-d', strtotime($buscaFormulario->fecha_personalidadJuridica));



                if($buscaFormulario->fecha_personalidadJuridica>date('Y-m-d')){

                    echo  Notification::widget([
                        'type' => 'error',
                        'message' => 'La fecha de la personalidad jurídica no puede ser mayor a la fecha actual.',
                        'options' => [
                            "closeButton" => false,
                            "debug" => false,
                            "newestOnTop" => false,
                            "progressBar" => false,
                            "positionClass" => "toast-top-right",
                            "preventDuplicates" => false,
                            "onclick" => null,
                            "showDuration" => "300",
                            "hideDuration" => "900",
                            "timeOut" => "4000",
                            "extendedTimeOut" => "900",
                            "showEasing" => "swing",
                            "hideEasing" => "linear",
                            "showMethod" => "fadeIn",
                            "hideMethod" => "fadeOut"
                        ]
                    ]);

                    $buscaFormulario->fecha_personalidadJuridica= date('d-m-Y', strtotime($buscaFormulario->fecha_personalidadJuridica));
                    return $this->render('section1', ['model' => $buscaFormulario,]);
                }

                if( $buscaFormulario->save()){
                    $buscaFormulario->fecha_personalidadJuridica= date('d-m-Y', strtotime($buscaFormulario->fecha_personalidadJuridica));
                    echo  Notification::widget([
                        'type' => 'success',
                        'message' => 'Los datos del formulario se han guardado correctamente.',
                        'options' => [
                            "closeButton" => false,
                            "debug" => false,
                            "newestOnTop" => false,
                            "progressBar" => false,
                            "positionClass" => "toast-top-right",
                            "preventDuplicates" => false,
                            "onclick" => null,
                            "showDuration" => "300",
                            "hideDuration" => "900",
                            "timeOut" => "4000",
                            "extendedTimeOut" => "900",
                            "showEasing" => "swing",
                            "hideEasing" => "linear",
                            "showMethod" => "fadeIn",
                            "hideMethod" => "fadeOut"
                        ]
                    ]);
                                                        
                    return $this->render('section1', ['model' => $buscaFormulario,]);

                }else{
                    $buscaFormulario->fecha_personalidadJuridica= date('d-m-Y', strtotime($buscaFormulario->fecha_personalidadJuridica));
                    return $this->render('section1', ['model' => $buscaFormulario,]);

                }
        }else{
                $buscaFormulario->fecha_personalidadJuridica= date('d-m-Y', strtotime($buscaFormulario->fecha_personalidadJuridica));
                return $this->render('section1', ['model' => $buscaFormulario,]);

        }
    }else{
            throw new NotFoundHttpException('La página solicitada no existe.');
        }
    }   
    
    public function actionSection2()
    {

        $id_usuario_actual=\Yii::$app->user->id;
        $buscaConcursante = Concursante::find()->where(['id' => $id_usuario_actual])->one();

        $request = Yii::$app->request;
        $id_postulacion = $request->get('id_postulacion');
        $area_subvencion = $request->post('area_subvencion');

        $buscaPostulacion = Postulacion::find()->where(['and',['id_postulacion' => $id_postulacion],['id_concursante' => $buscaConcursante->id_concursante]])->one();

        if($buscaPostulacion != null){

        $buscaFormulario = Formulario::find()->where(['id_postulacion' => $id_postulacion])->one();
        
        if($buscaFormulario->load(Yii::$app->request->post())){
            $buscaFormulario->area_subvencion= $area_subvencion;
            if($buscaFormulario->save()){
                echo  Notification::widget([
                        'type' => 'success',
                        //'title' => 'Bien hecho',
                        'message' => 'Los datos del formulario se han guardado correctamente.',
                        'options' => [
                            "closeButton" => false,
                            "debug" => false,
                            "newestOnTop" => false,
                            "progressBar" => false,
                            "positionClass" => "toast-top-right",
                            "preventDuplicates" => false,
                            "onclick" => null,
                            "showDuration" => "300",
                            "hideDuration" => "900",
                            "timeOut" => "4000",
                            "extendedTimeOut" => "900",
                            "showEasing" => "swing",
                            "hideEasing" => "linear",
                            "showMethod" => "fadeIn",
                            "hideMethod" => "fadeOut"
                        ]
                ]);
                return $this->render('section2', ['model' => $buscaFormulario,]);

            }else{
                return $this->render('section2', ['model' => $buscaFormulario,]);

            }
        }else{
            return $this->render('section2', ['model' => $buscaFormulario,]);

        }
    }else{
            throw new NotFoundHttpException('La página solicitada no existe.');
        }

    }       
    
    public function actionSection3()
    {

        $id_usuario_actual=\Yii::$app->user->id;
        $buscaConcursante = Concursante::find()->where(['id' => $id_usuario_actual])->one();
        $request = Yii::$app->request;
        $id_postulacion = $request->get('id_postulacion');

        $buscaPostulacion = Postulacion::find()->where(['and',['id_postulacion' => $id_postulacion],['id_concursante' => $buscaConcursante->id_concursante]])->one();

        if($buscaPostulacion != null){

        $buscaFormulario = Formulario::find()->where(['id_postulacion' => $id_postulacion])->one();
      
        if($buscaFormulario->load(Yii::$app->request->post())){
            if($buscaFormulario->save()){
                echo  Notification::widget([
                        'type' => 'success',
                        //'title' => 'Bien hecho',
                        'message' => 'Los datos del formulario se han guardado correctamente.',
                        'options' => [
                            "closeButton" => false,
                            "debug" => false,
                            "newestOnTop" => false,
                            "progressBar" => false,
                            "positionClass" => "toast-top-right",
                            "preventDuplicates" => false,
                            "onclick" => null,
                            "showDuration" => "300",
                            "hideDuration" => "900",
                            "timeOut" => "4000",
                            "extendedTimeOut" => "900",
                            "showEasing" => "swing",
                            "hideEasing" => "linear",
                            "showMethod" => "fadeIn",
                            "hideMethod" => "fadeOut"
                        ]
                ]);

                return $this->render('section3', ['model' => $buscaFormulario,]);

            }else{
                return $this->render('section3', ['model' => $buscaFormulario,]);
            }
            
        }else{
            return $this->render('section3', ['model' => $buscaFormulario,]);
        }

    }else{
            throw new NotFoundHttpException('La página solicitada no existe.');
        }

        
    }   

    public function actionSection4()
    {

        $id_usuario_actual=\Yii::$app->user->id;
        $buscaConcursante = Concursante::find()->where(['id' => $id_usuario_actual])->one();

        $request = Yii::$app->request;
        $id_postulacion = $request->get('id_postulacion');

        $buscaPostulacion = Postulacion::find()->where(['and',['id_postulacion' => $id_postulacion],['id_concursante' => $buscaConcursante->id_concursante]])->one();

        if($buscaPostulacion != null){

        $buscaFormulario = Formulario::find()->where(['id_postulacion' => $id_postulacion])->one();

        $id_formulario=$buscaFormulario->id_formulario;
        $searchModel = new TablapresupuestoSearch();
        $searchModel->id_formulario= $id_formulario;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $buscaPresupuestos= Tablapresupuesto::find()->where(['id_formulario' => $id_formulario])->all();
        $costoTotalPresupuesto=0;
        foreach ($buscaPresupuestos as $presupuesto) {
            $costoTotalPresupuesto+= $presupuesto->costoTotal;
        }
        $this->view->params['customParam'] = $costoTotalPresupuesto;
        return $this->render('section4', ['model' => $buscaFormulario,'searchModel' => $searchModel,'dataProvider' => $dataProvider, ]);

    }else{
            throw new NotFoundHttpException('La página solicitada no existe.');
        }
    
    }    
    
    public function actionSection5()
        {

            $id_usuario_actual=\Yii::$app->user->id;
            $buscaConcursante = Concursante::find()->where(['id' => $id_usuario_actual])->one();

            $request = Yii::$app->request;
            $id_postulacion = $request->get('id_postulacion');

            $buscaPostulacion = Postulacion::find()->where(['and',['id_postulacion' => $id_postulacion],['id_concursante' => $buscaConcursante->id_concursante]])->one();

            if($buscaPostulacion != null){

            $buscaFormulario = Formulario::find()->where(['id_postulacion' => $id_postulacion])->one();
            $id_formulario=$buscaFormulario->id_formulario;
            $searchModel = new TablaitemfinanciamientoSearch();
            $searchModel->id_formulario= $id_formulario;
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
             if($buscaFormulario->load(Yii::$app->request->post())){
            $buscaFinanciamiento = Tablaitemfinanciamiento::find()->where(['id_formulario' => $id_formulario])->all();//busca todos financiamientos asociados a ese formulario
            $costoTotalFinanciamiento=0;
            foreach ($buscaFinanciamiento as $financiamiento) {
                $costoTotalFinanciamiento+= $financiamiento->monto;
            }//obtiene el costo total de todos los financiamientos
            $aportePropio = (float) preg_replace('/[^0-9.]/', '', $buscaFormulario->financiamiento_aporte_propio);
            $aporteTerceros = (float) preg_replace('/[^0-9.]/', '', $buscaFormulario->financiamiento_aporte_terceros);

            $aporteSolicitado = $costoTotalFinanciamiento;
            $buscaFormulario->financiamiento_aporte_solicitado=$aporteSolicitado;
            $aporteTotal=$aporteSolicitado+$aportePropio+$aporteTerceros;
            $buscaFormulario->financiamiento_aporteTotal_proyecto = $aporteTotal.'';//los asigna

               $buscaFormulario->financiamiento_aporteTotal_proyecto = $aporteTotal.'';//los asigna
            

                if($buscaFormulario->save()){
                    echo  Notification::widget([
                        'type' => 'success',
                        //'title' => 'Bien hecho',
                        'message' => 'Los datos del formulario se han guardado correctamente.',
                        'options' => [
                            "closeButton" => false,
                            "debug" => false,
                            "newestOnTop" => false,
                            "progressBar" => false,
                            "positionClass" => "toast-top-right",
                            "preventDuplicates" => false,
                            "onclick" => null,
                            "showDuration" => "300",
                            "hideDuration" => "900",
                            "timeOut" => "4000",
                            "extendedTimeOut" => "900",
                            "showEasing" => "swing",
                            "hideEasing" => "linear",
                            "showMethod" => "fadeIn",
                            "hideMethod" => "fadeOut"
                        ]
                    ]);
                    return $this->render('section5', ['model' => $buscaFormulario,'searchModel' => $searchModel,'dataProvider' => $dataProvider,]);
                }else{
                    return $this->render('section5', ['model' => $buscaFormulario,'searchModel' => $searchModel,'dataProvider' => $dataProvider,]); 
                }

            }else{
                return $this->render('section5', ['model' => $buscaFormulario,'searchModel' => $searchModel,'dataProvider' => $dataProvider,]);
            }

    }else{
            throw new NotFoundHttpException('La página solicitada no existe.');
        }
 
    }   

    public function actionSection6()
    {

        $id_usuario_actual=\Yii::$app->user->id;
        $buscaConcursante = Concursante::find()->where(['id' => $id_usuario_actual])->one();

        $request = Yii::$app->request;
        $id_postulacion = $request->get('id_postulacion');

        $buscaPostulacion = Postulacion::find()->where(['and',['id_postulacion' => $id_postulacion],['id_concursante' => $buscaConcursante->id_concursante]])->one();

        if($buscaPostulacion != null){

        $buscaFormulario = Formulario::find()->where(['id_postulacion' => $id_postulacion])->one();        
        $id_formulario=$buscaFormulario->id_formulario;
        $searchModel = new TablacartaganttSearch();
        $searchModel->id_formulario= $id_formulario;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('section6', ['model' => $buscaFormulario,'searchModel' => $searchModel,'dataProvider' => $dataProvider,]);

        }else{
            throw new NotFoundHttpException('La página solicitada no existe.');
        }    

    }
    
    public function actionSection7()
    {

        $id_usuario_actual=\Yii::$app->user->id;
        $buscaConcursante = Concursante::find()->where(['id' => $id_usuario_actual])->one();

        $request = Yii::$app->request;
        $id_postulacion = $request->get('id_postulacion');

        $buscaPostulacion = Postulacion::find()->where(['and',['id_postulacion' => $id_postulacion],['id_concursante' => $buscaConcursante->id_concursante]])->one();

        if($buscaPostulacion != null){

        $buscaFormulario = Formulario::find()->where(['id_postulacion' => $id_postulacion])->one();
        $id_formulario=$buscaFormulario->id_formulario;
        $searchModel = new TipoarchivoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('section7', ['model' => $buscaFormulario,'searchModel' => $searchModel,'dataProvider' => $dataProvider,]);

        }else{
            throw new NotFoundHttpException('La página solicitada no existe.');
        }

    }

    public function actionSection8()
    {

        $id_usuario_actual=\Yii::$app->user->id;
        $buscaConcursante = Concursante::find()->where(['id' => $id_usuario_actual])->one();

        $request = Yii::$app->request;
        $id_postulacion = $request->get('id_postulacion');

        $buscaPostulacion = Postulacion::find()->where(['and',['id_postulacion' => $id_postulacion],['id_concursante' => $buscaConcursante->id_concursante]])->one();

        if($buscaPostulacion != null){

        $buscaFormulario = Formulario::find()->where(['id_postulacion' => $id_postulacion])->one();
        
        if($buscaFormulario->load(Yii::$app->request->post())){
            return $this->render('section8', ['model' => $buscaFormulario,]);

        }else{
            return $this->render('section8', ['model' => $buscaFormulario,]);

        }

    }else{
            throw new NotFoundHttpException('La página solicitada no existe.');
        }

    }       

        public function actionBases()
    {
        $buscaNoticia = Noticia::find()->where(['id_noticia' => 2])->one();
        return $this->render('bases', [
            'model' => $buscaNoticia,
        ]);
    }
        public function actionPreguntasfrecuentes()
    {
        $buscaNoticia = Noticia::find()->where(['id_noticia' => 2])->one();
        return $this->render('preguntasfrecuentes', [
            'model' => $buscaNoticia,
        ]);
    }


public function actionDescargarborrador(){
     
       
        $request = Yii::$app->request;
        $id_postulacion = $request->get('id_postulacion');

        $buscaFormulario = Formulario::find()->where(['id_postulacion' => $id_postulacion])->one(); 

        if($buscaFormulario != null){


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
            'SetFooter' => ['Este documento es el borrador de su formulario, por lo tanto no es válido. <br> Este borrador fue generado el: ' .$fecha_mostrar],
            'SetHeader' => ['Este documento es el borrador de su formulario, por lo tanto no es válido.'],
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

    }

   public function actionDescargarpostulacion(){
     
       
        $request = Yii::$app->request;
        $id_convocatoria = $request->get('id_convocatoria');

        $buscaConvocatoria = Convocatoria::find()->where(['id_convocatoria' => $id_convocatoria])->one();

        if($buscaConvocatoria != null){

        $this->id_convocatoria=$id_convocatoria;
        $id_usuario__actual=\Yii::$app->user->id;
        $concursante_actual= Concursante::find()->where(['id' =>$id_usuario__actual])->one();
        $obtieneid_concursante=$concursante_actual->id_concursante;
        $buscaPostulacion = Postulacion::find()->where(['and',['id_convocatoria' => $id_convocatoria],['id_concursante' => $obtieneid_concursante]])->one(); 
        $id_postulacionencontrada=$buscaPostulacion->id_postulacion;
        $buscaFormulario = Formulario::find()->where(['id_postulacion' => $id_postulacionencontrada])->one(); 

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

    }

        public function actionResultados()
    {
        $model = new Postulacion();
        $searchModel = new PostulacionSearch2();

        $params = Yii::$app->request->queryParams;

        if (count($params) <= 1) {
            $params = Yii::$app->session['postulacionparams20'];
            if(isset(Yii::$app->session['postulacionparams20']['page']))
                $_GET['page'] = Yii::$app->session['postulacionparams20']['page'];
        } else {
                Yii::$app->session['postulacionparams20'] = $params;
        }

        $dataProvider = $searchModel->search($params);

        return $this->render('resultados', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


      public function actionMostrardetallepostulacion()
    {
        $request = Yii::$app->request;
        $id_convocatoria = $request->get('id_convocatoria');

        $buscaConvocatoria = Convocatoria::find()->where(['and',['id_convocatoria' => $id_convocatoria],['id_estadoConvocatoria' => 3]])->one();
        $this->id_convocatoria=$id_convocatoria;
        $id_usuario__actual=\Yii::$app->user->id;
        $concursante_actual= Concursante::find()->where(['id' =>$id_usuario__actual])->one();
        $obtieneid_concursante=$concursante_actual->id_concursante;
        $buscaPostulacion = Postulacion::find()->where(['and',['id_convocatoria' => $id_convocatoria],['id_concursante' => $obtieneid_concursante]])->one();

        if($buscaPostulacion != null && $buscaConvocatoria != null){

        $id_postulacion=$buscaPostulacion->id_postulacion;
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

    public function actionSubcat(){
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $cat_id = $parents[0];
                $query = new \yii\db\Query();
                $out = $query->select('id_convocatoria as id, nombreConvocatoria as name')
                    ->from('convocatoria')->where(['id_fondo' => $cat_id])->all();

                $arregloSimple = [];
                foreach ($out as $fila){
                    $arregloSimple[] = $fila;

                }
                // the getSubCatList function will query the database based on the
                // cat_id and return an array like below:
                // [
                //    ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
                //    ['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
                // ]
                echo Json::encode(['output'=>$out, 'selected'=>'']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
}
