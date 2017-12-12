<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use backend\models\Convocatoria;
use backend\models\Concursante;
use backend\models\Postulacion;
use backend\models\CorreoForm;
use backend\models\Estadoresultado;
use backend\models\Estadoconvocatoria;
use backend\models\User;
use backend\models\ConvocatoriaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Evaluacion;
use backend\models\Resultado;

/**
 * ConvocatoriaController implements the CRUD actions for Convocatoria model.
 */
class ConvocatoriaController extends Controller
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
                        'actions' => ['index', 'correo','enviarcorreosconcursantes', 'enviarcorreo', 'enviarresultados', 'publicar', 'publicacion', 'create', 'update', 'update2', 'delete','cambiarestado'],
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
                ],
            ],
        ];
    }

    /**
     * Lists all Convocatoria models.
     * @return mixed
     */
    public function actionIndex()
    {

    if ( (User::isUserAdmin(Yii::$app->user->identity->id) == true) ){
        $searchModel = new ConvocatoriaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }else{
        Yii::$app->session->setFlash('error', 'No tienes autorización para ingresar a esta sección.');
        return Yii::$app->getResponse()->redirect(['/site/index']);
    }

    }

    public function actionCorreo()
    {

    if ( (User::isUserAdmin(Yii::$app->user->identity->id) == true) ){

        $searchModel = new ConvocatoriaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render('correo', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }else{
        Yii::$app->session->setFlash('error', 'No tienes autorización para ingresar a esta sección.');
        return Yii::$app->getResponse()->redirect(['/site/index']);
    }

    }


 public function actionEnviarcorreo()
    {

    if ( (User::isUserAdmin(Yii::$app->user->identity->id) == true) ){

        $request = Yii::$app->request;
        $id_convocatoria = $request->get('id_convocatoria');
        $model = new CorreoForm();
        $buscaPostulaciones = Postulacion::find()->where(['id_convocatoria' => $id_convocatoria])->all();
        $convocatoria =  Convocatoria::find()->where(['id_convocatoria' => $id_convocatoria])->one();

        if($convocatoria != null){

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            
        foreach ($buscaPostulaciones as $postulacion) {
            # code...
            $id_concursante= $postulacion->id_concursante;
            $id_postulacion= $postulacion->id_postulacion;
            $buscaConcursante= Concursante::find()->where(['id_concursante' => $id_concursante])->one();
            $id_usuario= $buscaConcursante->id;
            $usuario= User::find()->where(['id' => $id_usuario, 'role'=>5])->one();

            Yii::$app->mailer->compose("@app/mail/layouts/html", ["content" => $model->body])
                        ->setTo($usuario->email)
                        //.>setCc()
                        ->setFrom('contacto.municipalidad.yungay@gmail.com')
                        ->setSubject($model->subject)
                        ->send();

        }


        $administradores= User::find()->where(['role'=>1])->all();

        foreach($administradores as $admin){

                        Yii::$app->mailer->compose("@app/mail/layouts/html", ["content" => $model->body])
                        ->setTo($admin->email)
                        ->setFrom('contacto.municipalidad.Yungay@gmail.com')
                        ->setSubject($model->subject)
                        ->send();
        }



        Yii::$app->session->setFlash('success', 'El correo ha sido enviado exitosamente a los concursantes de la convocatoria '.$convocatoria->nombreConvocatoria.' ');
         return Yii::$app->getResponse()->redirect(['/convocatoria/correo']);
        } else {
            return $this->render('correoform', [
                'model' => $model,
            ]);
        }

    }else{
            throw new NotFoundHttpException('La página solicitada no existe.');
        }

    }else{
        Yii::$app->session->setFlash('error', 'No tienes autorización para ingresar a esta sección.');
        return Yii::$app->getResponse()->redirect(['/site/index']);
    }

    }


    public function actionEnviarcorreosconcursantes(){


        if ( (User::isUserAdmin(Yii::$app->user->identity->id) == true) ){

        $model = new CorreoForm();
        $buscaUsuarios= User::find()->where(['role'=>5])->all();


        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            
        foreach ($buscaUsuarios as $usuario) {
            # code...
      
            Yii::$app->mailer->compose("@app/mail/layouts/html", ["content" => $model->body])
                        ->setTo($usuario->email)
                        //.>setCc()
                        ->setFrom('contacto.municipalidad.yungay@gmail.com')
                        ->setSubject($model->subject)
                        ->send();


        }



        $administradores= User::find()->where(['role'=>1])->all();

        foreach($administradores as $admin){

                        Yii::$app->mailer->compose("@app/mail/layouts/html", ["content" => $model->body])
                        ->setTo($admin->email)
                        ->setFrom('contacto.municipalidad.Yungay@gmail.com')
                        ->setSubject($model->subject)
                        ->send();
        }



        Yii::$app->session->setFlash('success', 'El correo ha sido enviado exitosamente a todos los concursantes registrados en el sistema ');
         return Yii::$app->getResponse()->redirect(['/convocatoria/correo']);
        } else {
            return $this->render('correoform2', [
                'model' => $model,
            ]);
        }

 

    }else{
        Yii::$app->session->setFlash('error', 'No tienes autorización para ingresar a esta sección.');
        return Yii::$app->getResponse()->redirect(['/site/index']);
    }
    }



 
    public function actionEnviarresultados()
    {
    if ( (User::isUserAdmin(Yii::$app->user->identity->id) == true) ){
        $request = Yii::$app->request;
        $id_convocatoria = $request->get('id_convocatoria');
        $model =  Convocatoria::find()->where(['id_convocatoria' => $id_convocatoria])->one();

        if($model != null){

        $searchModel = new ConvocatoriaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $buscaPostulaciones = Postulacion::find()->where(['id_convocatoria' => $id_convocatoria])->all();
        foreach ($buscaPostulaciones as $postulacion) {
            # code...
            $id_concursante= $postulacion->id_concursante;
            $id_postulacion= $postulacion->id_postulacion;
            $buscaConcursante= Concursante::find()->where(['id_concursante' => $id_concursante])->one();
            $id_usuario= $buscaConcursante->id;
            $usuario= User::find()->where(['id' => $id_usuario])->one();
            $evaluacion= Evaluacion::find()->where(['id_postulacion' => $id_postulacion])->one();
            if(isset($evaluacion)){
                $id_evaluacion= $evaluacion->id_evaluacion;
                $resultado= Resultado::find()->where(['id_evaluacion' => $id_evaluacion])->one();
               
                if($resultado==false){
                    $content = '<p>Estimado(a) ' . $buscaConcursante->nombreConcursante . '<br>Junto con saludarle, le informo a usted los resultados de su postulación a la convocatoria "'.$model->nombreConvocatoria.'":<br>Estado: <strong>Rechazada</strong><br>'
                    .'Explicación del evaluador:<ul><li>
                    '.$evaluacion->observaciones_1.'</li></ul>'
                    .'<br><br>Este es un correo automático generado por el Sistema de Postulación a Subvenciones Municipales de la Ilustre Municipalidad de Yungay, por favor no responder. '
                    .'<br>Para consultas llamar a Mesa Central al Fono: 42 - 2 205 600.'
                    .'<br><br>Saludos Cordiales<br>Ilustre Municipalidad de Yungay.<br>';


                }else{
                     $estadoresultado= Estadoresultado::find()->where(['id_estado'=>$resultado->id_estado])->one();
                    $aux_monto='';
                    $aux_resultado='';
                     if($estadoresultado->descripcion_estado=='Asignado') $aux_resultado='Beneficio asignado';
                    if($estadoresultado->descripcion_estado=='No asignado') $aux_resultado='Sin asignación de beneficio';
                  
                    if($estadoresultado->descripcion_estado=='Asignado') $aux_monto='$'.number_format($postulacion->montoAsignado, 0, ",", ".");
                    if($estadoresultado->descripcion_estado=='No asignado') $aux_monto='No tiene un monto asignado';
                    $puntaje_total=''.$evaluacion->puntaje_1+$evaluacion->puntaje_2+$evaluacion->puntaje_3;
                    $content = '<p>Estimado(a) ' . $buscaConcursante->nombreConcursante . '<br>Junto con saludarle, le informo a usted los resultados de su postulación a la convocatoria "'.$model->nombreConvocatoria.'":
                    <br> Resultado de la postulación a la subvención: <strong>'.$aux_resultado.'</strong>.<br>
                     Puntaje total: '.$puntaje_total.' puntos.<br>
                     Monto asignado: '.$aux_monto.' pesos. <br>
                     Resultados por etapa:'
                    .'<ul>
                    <li>Etapa 1: Revisión de documentos y Grado de Colaboración con la Función Municipal: <br>Puntaje: '.$evaluacion->puntaje_1.' puntos. 
                    <br>Observaciones del evaluador: '.$evaluacion->observaciones_1.''.'</li>
                    <li>Etapa 2: Grado de Cobertura: <br>Puntaje: '.$evaluacion->puntaje_2.' puntos. <br>Observaciones: '.$evaluacion->observaciones_2.'</li><br><br>'
                    .'<li>Etapa 3: Grado de participación de la entidad en el financiamiento del proyecto: <br>Puntaje: '.$evaluacion->puntaje_3.' puntos.<br>Observaciones: '.$evaluacion->observaciones_3.'</li></ul>'
                    .'<br><br>Este es un correo automático generado por el Sistema de Postulación a Subvenciones Municipales de la Ilustre Municipalidad de Yungay, por favor no responder. '
                    .'<br>Para consultas llamar a Mesa Central al Fono: 42 - 2 205 600.'
                    .'<br><br>Saludos Cordiales<br>Ilustre Municipalidad de Yungay.<br>';



                }
               
            }else{

                    $content = '<p>Estimado(a) ' . $buscaConcursante->nombreConcursante . '<br>Junto con saludarle, le informo a usted los resultados de su postulación a la convocatoria "'.$model->nombreConvocatoria.'":<br>
                   <strong>El formulario no fue completado por lo tanto no cumple con los requisitos mínimos para obtener una subvención</strong><br>'
                    .'<br><br>Este es un correo automático generado por el Sistema de Postulación a Subvenciones Municipales de la Ilustre Municipalidad de Yungay, por favor no responder. '
                    .'<br>Para consultas llamar a Mesa Central al Fono: 42 - 2 205 600.'
                    .'<br><br>Saludos Cordiales<br>Ilustre Municipalidad de Yungay.<br>';


            }

                 Yii::$app->mailer->compose("@app/mail/layouts/html", ["content" => $content])
                        ->setTo($usuario->email)
                        ->setFrom('contacto.municipalidad.Yungay@gmail.com')
                        ->setSubject('Resultado de la convocatoria: ' . $model->nombreConvocatoria)
                        ->send();

        
           

        }

        $administradores= User::find()->where(['role'=>1])->all();

       
        foreach($administradores as $admin){


             $content2 = '<p>Estimado(a) ' . $admin->name . '<br>Junto con saludarle, le informo a usted que han sido enviados los resultados de la convocatoria "'.$model->nombreConvocatoria.'".<br><br>'
                    .'<br><br>Este es un correo automático generado por el Sistema de Postulación a Subvenciones Municipales de la Ilustre Municipalidad de Yungay, por favor no responder. '
                    .'<br>Para consultas llamar a Mesa Central al Fono: 42 - 2 205 600.'
                    .'<br><br>Saludos Cordiales<br>Ilustre Municipalidad de Yungay.<br>';



                        Yii::$app->mailer->compose("@app/mail/layouts/html", ["content" => $content2])
                        ->setTo($admin->email)
                        ->setFrom('contacto.municipalidad.Yungay@gmail.com')
                        ->setSubject('Resultado de la convocatoria: ' . $model->nombreConvocatoria)
                        ->send();


        }
         

        Yii::$app->session->setFlash('success', 'Los resultados han sido enviados exitosamente a los concursantes mediante correo electrónico.');
        return Yii::$app->getResponse()->redirect(['convocatoria/correo']);


    }else{
            throw new NotFoundHttpException('La página solicitada no existe.');
        }

    }else{
        Yii::$app->session->setFlash('error', 'No tienes autorización para ingresar a esta sección.');
        return Yii::$app->getResponse()->redirect(['/site/index']);
    }
}
   

    public function actionPublicar()
    {

    if ( (User::isUserAdmin(Yii::$app->user->identity->id) == true) ){

        $searchModel = new ConvocatoriaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider->query->where(['convocatoria.id_estadoConvocatoria' => 2])->one();

        return $this->render('publicar', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }else{
        Yii::$app->session->setFlash('error', 'No tienes autorización para ingresar a esta sección.');
        return Yii::$app->getResponse()->redirect(['/site/index']);
    }

    }

  public function actionPublicacion()
    {

    if ( (User::isUserAdmin(Yii::$app->user->identity->id) == true) ){

        $request = Yii::$app->request;
        $id_convocatoria = $request->get('id_convocatoria');
        $buscaConvocatoriaValidar = Convocatoria::find()->where(['id_convocatoria' => $id_convocatoria])->one();

        if($buscaConvocatoriaValidar != null){

                $cont = 0;
               $buscaPostulacion = Postulacion::find()->joinWith('evaluacion')->andWhere(['id_convocatoria' => $id_convocatoria])->andWhere(['>','evaluacion.id_estado', 1])->all();
               foreach ($buscaPostulacion as $postulacion){
                if($postulacion->evaluacion->id_estado == 2){
                    $cont ++;                
               }else{
                    if($postulacion->evaluacion->id_estado == 3){
                        $buscaResultado = Resultado::find()->where(['and',['id_evaluacion' => $postulacion->evaluacion->id_evaluacion],['id_estado' => 3]])->one();
                        if($buscaResultado != null){
                            $cont ++;
                        }else{
                            $buscaResultado2 = Resultado::find()->where(['and',['id_evaluacion' => $postulacion->evaluacion->id_evaluacion],['id_estado' => 2]])->one();
                            if($buscaResultado2 != null){
                                if($postulacion->montoAsignado != null){
                                    $cont++;
                                }

                            }
                        }

                    }
                }
            }  

             
        if($cont > 0){
            $buscaPostulacionEnviadas = Postulacion::find()->where(['and',['id_convocatoria' => $id_convocatoria],['id_estadopostulacion' => 2]])->count();
            if($cont == $buscaPostulacionEnviadas){
            
                $buscaConvocatoria = Convocatoria::find()->where(['id_convocatoria'=>$id_convocatoria])->one();
                $buscaPostulacionesAsignadas = Postulacion::find()->joinWith('evaluacion')->andWhere(['postulacion.id_convocatoria' => $id_convocatoria])->andWhere(['evaluacion.etapa' => 3])->all();

        foreach($buscaPostulacionesAsignadas as $postulacionesAsignadas){
            $postulacionesAsignadas->id_estadopostulacion = 3;
            $postulacionesAsignadas->evaluacion->etapa = 4;
            $postulacionesAsignadas->evaluacion->save();
            $postulacionesAsignadas->save();
        }

        $buscaPostulacionesNoAsignadas = Postulacion::find()->where(['id_convocatoria' => $id_convocatoria])->andWhere(['<>','id_estadopostulacion',3])->all();
        
        foreach($buscaPostulacionesNoAsignadas as $postulacionesNoAsignadas){
            $postulacionesNoAsignadas->id_estadopostulacion = 4;
            $buscaEvaluacionPostulacionNoAsignada = Evaluacion::find()->where(['id_postulacion' => $postulacionesNoAsignadas->id_postulacion])->one();
            if($buscaEvaluacionPostulacionNoAsignada != null){
                $postulacionesNoAsignadas->evaluacion->etapa = 4;
                $postulacionesNoAsignadas->evaluacion->save();
            }
            $postulacionesNoAsignadas->save();
        }
        $buscaConvocatoria->id_estadoConvocatoria = 3;
        $buscaConvocatoria->save();
        Yii::$app->session->setFlash('success', 'La convocatoria '.$buscaConvocatoria->nombreConvocatoria.' ha sido publicada.');
        return Yii::$app->getResponse()->redirect(['/convocatoria/publicar']);        
                        
            }else{
                Yii::$app->session->setFlash('error', 'Debe evaluar todas las postulaciones enviadas antes de publicar resultados.');
                return Yii::$app->getResponse()->redirect(['/convocatoria/publicar']);
            }
        }else{
            Yii::$app->session->setFlash('error', 'No hay ninguna postulación evaluada para publicar resultados.');
            return Yii::$app->getResponse()->redirect(['/convocatoria/publicar']);
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
     * Creates a new Convocatoria model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
     public function actionCreate()
    {

    if ( (User::isUserAdmin(Yii::$app->user->identity->id) == true) ){

        $model = new Convocatoria();
        $searchModel = new ConvocatoriaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
         
        if ($model->load(Yii::$app->request->post())) {


            //$model->fecha_inicio= date('Y-m-d H:i:s', strtotime($model->fecha_inicio));
            //$model->fecha_termino= date('Y-m-d H:i:s', strtotime($model->fecha_termino));
            $model->fecha_inicio= date('Y-m-d', strtotime($model->fecha_inicio));
            $model->fecha_termino= date('Y-m-d', strtotime($model->fecha_termino));
            date_default_timezone_set('America/Santiago');
            $fecha_actual= getdate();


            $fecha_hoy= date('Y-m-d', strtotime($fecha_actual['year'].'-'.$fecha_actual['mon'].'-'.$fecha_actual['mday']));
            if($model->fecha_inicio>=$fecha_hoy){
                if($model->fecha_inicio==$fecha_hoy) $model->id_estadoConvocatoria=1;
                if($model->fecha_inicio>$fecha_hoy) $model->id_estadoConvocatoria=2;

              if($model->fecha_inicio < $model->fecha_termino){
                if($model->save()){
                    Yii::$app->session->setFlash('success', 'La convocatoria ha sido guardada correctamente.');
                    return Yii::$app->getResponse()->redirect(['/convocatoria/index']);
                }else{
                    $model->fecha_inicio= date('d-m-Y', strtotime($model->fecha_inicio));
        $model->fecha_termino= date('d-m-Y', strtotime($model->fecha_termino));
     
                    Yii::$app->session->setFlash('error', 'La convocatoria no ha podido ser guardada.');
                         return $this->render('create', [
                        'model' => $model,
                        ]);
                }

              }else{
                $model->fecha_inicio= date('d-m-Y', strtotime($model->fecha_inicio));
        $model->fecha_termino= date('d-m-Y', strtotime($model->fecha_termino));
     
                    Yii::$app->session->setFlash('error', 'La fecha de inicio no puede ser mayor o igual a la fecha de término.');
                         return $this->render('create', [
                        'model' => $model,
                        ]);
             }

            }else{
                $model->fecha_inicio= date('d-m-Y', strtotime($model->fecha_inicio));
        $model->fecha_termino= date('d-m-Y', strtotime($model->fecha_termino));
     
                    Yii::$app->session->setFlash('error', 'La fecha de inicio no puede ser menor a la fecha actual.');
                         return $this->render('create', [
                        'model' => $model,
                        ]);

            }
       
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }

    }else{
        Yii::$app->session->setFlash('error', 'No tienes autorización para ingresar a esta sección.');
        return Yii::$app->getResponse()->redirect(['/site/index']);
    }

    }


    /**
     * Updates an existing Convocatoria model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
        public function actionUpdate()
    {

    if ( (User::isUserAdmin(Yii::$app->user->identity->id) == true) ){

        $request = Yii::$app->request;
        $id_convocatoria=$request->get('id_convocatoria');
        $model = $this->findModel($id_convocatoria);

        if($model != null){

        $searchModel = new ConvocatoriaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model->fecha_inicio= date('d-m-Y', strtotime($model->fecha_inicio));
        $model->fecha_termino= date('d-m-Y', strtotime($model->fecha_termino));
        date_default_timezone_set('America/Santiago');
        $fecha_actual= getdate();
        $fecha_hoy= date('Y-m-d', strtotime($fecha_actual['year'].'-'.$fecha_actual['mon'].'-'.$fecha_actual['mday']));

        if ($model->load(Yii::$app->request->post())) {


            $buscaMontos= Postulacion::find()->where(['id_convocatoria' => $model->id_convocatoria])->all();
            if($buscaMontos != null){
                $sumaMontos=0;
                foreach ($buscaMontos as $montos) {
                    $sumaMontos+= $montos->montoAsignado;
                }
                $monto_total = $model->montoConvocatoria-$sumaMontos;
                if($monto_total < 0){
                    Yii::$app->session->setFlash('error', 'El monto total de la subvención no puede ser inferior al total del monto que ya ha sido asignado ($'.number_format($sumaMontos, 0, ",", ".").' pesos).');
                    return $this->render('update', [
                    'model' => $model,
                    ]);
                } 
            }

                $model->fecha_inicio= date('Y-m-d', strtotime($model->fecha_inicio));
                $model->fecha_termino= date('Y-m-d', strtotime($model->fecha_termino));

            if($model->fecha_inicio < $model->fecha_termino){  
             if($model->fecha_inicio==$fecha_hoy) $model->id_estadoConvocatoria=1;
                if($model->fecha_inicio>$fecha_hoy) $model->id_estadoConvocatoria=2;
                    if($model->fecha_termino>=$fecha_hoy) $model->id_estadoConvocatoria=1;
         
                if($model->save()){
                    Yii::$app->session->setFlash('success', 'La convocatoria ha sido modificada correctamente.');
                    return Yii::$app->getResponse()->redirect(['/convocatoria/index']);
                }else{
                    Yii::$app->session->setFlash('error', 'La convocatoria no ha podido ser modificada.');
                    return $this->render('update', [
                    'model' => $model,
                    ]);
                }
            }else{
                $model->fecha_inicio= date('d-m-Y', strtotime($model->fecha_inicio));
        $model->fecha_termino= date('d-m-Y', strtotime($model->fecha_termino));
     
                    Yii::$app->session->setFlash('error', 'La fecha de inicio no puede ser mayor o igual a la fecha de término.');
                         return $this->render('update', [
                        'model' => $model,
                        ]);                
            }
        } else {
            $model->fecha_inicio= date('d-m-Y', strtotime($model->fecha_inicio));
            $model->fecha_termino= date('d-m-Y', strtotime($model->fecha_termino));
            return $this->render('update', [
                'model' => $model,
            ]);
        }


    }else{
            throw new NotFoundHttpException('La página solicitada no existe.');
        }

    }else{
        Yii::$app->session->setFlash('error', 'No tienes autorización para ingresar a esta sección.');
        return Yii::$app->getResponse()->redirect(['/site/index']);
    }

    }

    public function actionUpdate2()
    {

    if ( (User::isUserAdmin(Yii::$app->user->identity->id) == true) ){

        $request = Yii::$app->request;
        $id_convocatoria=$request->get('id_convocatoria');
        $model = $this->findModel($id_convocatoria);

        if($model != null){

        $searchModel = new ConvocatoriaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
         $model->fecha_inicio= date('d-m-Y', strtotime($model->fecha_inicio));
        $model->fecha_termino= date('d-m-Y', strtotime($model->fecha_termino));
          date_default_timezone_set('America/Santiago');
            $fecha_actual= getdate();


            $fecha_hoy= date('Y-m-d', strtotime($fecha_actual['year'].'-'.$fecha_actual['mon'].'-'.$fecha_actual['mday']));
       
        if ($model->load(Yii::$app->request->post())) {


            $buscaMontos= Postulacion::find()->where(['id_convocatoria' => $model->id_convocatoria])->all();
            if($buscaMontos != null){
                $sumaMontos=0;
                foreach ($buscaMontos as $montos) {
                    $sumaMontos+= $montos->montoAsignado;
                }
                $monto_total = $model->montoConvocatoria-$sumaMontos;
                if($monto_total < 0){
                    Yii::$app->session->setFlash('error', 'El monto total de la subvención no puede ser inferior al total del monto que ya ha sido asignado ($'.number_format($sumaMontos, 0, ",", ".").' pesos).');
                    return $this->render('update2', [
                    'model' => $model,
                    ]);
                } 
            }

                $model->fecha_inicio= date('Y-m-d', strtotime($model->fecha_inicio));
                $model->fecha_termino= date('Y-m-d', strtotime($model->fecha_termino));
            if($model->fecha_inicio < $model->fecha_termino){  
             if($model->fecha_inicio==$fecha_hoy) $model->id_estadoConvocatoria=1;
                if($model->fecha_inicio>$fecha_hoy) $model->id_estadoConvocatoria=2;
                    if($model->fecha_termino>=$fecha_hoy) $model->id_estadoConvocatoria=1;
                if($model->save()){
                    Yii::$app->session->setFlash('success', 'La convocatoria ha sido modificada correctamente.');
                    return Yii::$app->getResponse()->redirect(['/convocatoria/index']);
                }else{
                    $model->fecha_inicio= date('d-m-Y', strtotime($model->fecha_inicio));
        $model->fecha_termino= date('d-m-Y', strtotime($model->fecha_termino));
     
                    Yii::$app->session->setFlash('error', 'La convocatoria no ha podido ser modificada.');
                    return $this->render('update2', [
                    'model' => $model,
                    ]);
                }
            }else{
                $model->fecha_inicio= date('d-m-Y', strtotime($model->fecha_inicio));
        $model->fecha_termino= date('d-m-Y', strtotime($model->fecha_termino));
     
                    Yii::$app->session->setFlash('error', 'La fecha de inicio no puede ser mayor o igual a la fecha de término.');
                         return $this->render('update2', [
                        'model' => $model,
                        ]);                
            }
        } else {
            $model->fecha_inicio= date('d-m-Y', strtotime($model->fecha_inicio));
            $model->fecha_termino= date('d-m-Y', strtotime($model->fecha_termino));
            return $this->render('update2', [
                'model' => $model,
            ]);
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
     * Deletes an existing Convocatoria model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete()
    {
    if ( (User::isUserAdmin(Yii::$app->user->identity->id) == true) ){

        $request = Yii::$app->request;
        $id_convocatoria=$request->get('id_convocatoria');

        $buscaConvocatoriaValidar = Convocatoria::find()->where(['id_convocatoria' => $id_convocatoria])->one();

        if($buscaConvocatoriaValidar != null){

        $this->findModel($id_convocatoria)->delete();
        Yii::$app->session->setFlash('success', 'La convocatoria ha sido eliminada.');
        return Yii::$app->getResponse()->redirect(['/convocatoria/index']);


        }else{
            throw new NotFoundHttpException('La página solicitada no existe.');
        }

    }else{
        Yii::$app->session->setFlash('error', 'No tienes autorización para ingresar a esta sección.');
        return Yii::$app->getResponse()->redirect(['/site/index']);
    }

    }

    /**
     * Finds the Convocatoria model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Convocatoria the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Convocatoria::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('La página solicitada no existe.');
        }
    }

    public function actionCambiarestado()
    {
        if ( (User::isUserAdmin(Yii::$app->user->identity->id) == true) ){  
            $request = Yii::$app->request;
            $id_convocatoria=$request->get('id_convocatoria');

            $buscaConvocatoria = Convocatoria::find()->where(['id_convocatoria' => $id_convocatoria])->one();

            if($buscaConvocatoria != null){
                if($buscaConvocatoria->id_estadoConvocatoria == 1){
                        $buscaConvocatoria->id_estadoConvocatoria = 4;
                        $buscaConvocatoria->save();
                        Yii::$app->session->setFlash('success', 'La convocatoria ha sido pausada.');
                        return Yii::$app->getResponse()->redirect(['/convocatoria/index']);
                }else{
                    if($buscaConvocatoria->id_estadoConvocatoria == 4){
                        $buscaConvocatoria->id_estadoConvocatoria = 1;
                        $buscaConvocatoria->save();
                        Yii::$app->session->setFlash('success', 'La convocatoria ha sido reanudada.');
                        return Yii::$app->getResponse()->redirect(['/convocatoria/index']);
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

}
