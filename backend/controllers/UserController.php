<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use common\models\User;
use backend\models\Concursante;
use backend\models\CorreoForm;
use backend\models\UserSearch;
use backend\models\Modificaruser;
use backend\models\SignupForm;
use backend\models\Cambiarpassword;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
                        'actions' => ['index', 'create', 'estado','delete','cambiarpassword','enviarcorreo','modificaruser','detalle'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'estado' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {

        if ( (User::isUserAdmin(Yii::$app->user->identity->id) == true) ){

        $searchModel = new UserSearch();
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

    public function actionEnviarcorreo()
    {

    if ( (User::isUserAdmin(Yii::$app->user->identity->id) == true) ){

        $admin= User::find()->where(['id'=>Yii::$app->user->identity->id])->one();
        $request = Yii::$app->request;
        $id_usuario = $request->get('id');
        $usuario= User::find()->where(['id'=>$id_usuario])->one();
        $model = new CorreoForm();
        $concursante =  Concursante::find()->where(['id' => $id_usuario])->one();

        if($usuario != null){

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            
       
            Yii::$app->mailer->compose("@app/mail/layouts/html", ["content" => $model->body])
                        ->setTo($usuario->email)
                        ->setCc($admin->email)
                        ->setFrom('contacto.municipalidad.yungay@gmail.com')
                        ->setSubject($model->subject)
                        ->send();


    

        Yii::$app->session->setFlash('success', 'El correo ha sido enviado exitosamente a '.$usuario->name.' ');
         return Yii::$app->getResponse()->redirect(['/user/index']);
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

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        if ( (User::isUserAdmin(Yii::$app->user->identity->id) == true) ){

        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post())) {

            if ($user = $model->signup()) {
            Yii::$app->session->setFlash('success', 'La cuenta se ha creado correctamente.');
            return Yii::$app->getResponse()->redirect(['/user/index']);
            }else{
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

    public function actionEstado($id){

        if ( (User::isUserAdmin(Yii::$app->user->identity->id) == true) ){

        $model = $this->findModel($id);
        if($model != null){
        if($model->status == 10){
            $model->status = 0;
            $model->save();
            Yii::$app->session->setFlash('success', 'La cuenta de '.$model->name.' ha sido bloqueada.');
            return Yii::$app->getResponse()->redirect(['/user/index']);
        }else{
            $model->status = 10;
            $model->save();            
            Yii::$app->session->setFlash('success', 'La cuenta de '.$model->name.' ha sido activada.');
            return Yii::$app->getResponse()->redirect(['/user/index']);
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
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if ( (User::isUserAdmin(Yii::$app->user->identity->id) == true) ){
        
        $model = $this->findModel($id);

        if($model != null){

        Yii::$app->session->setFlash('success', 'La cuenta de '.$model->name.' ha sido eliminada.');
        $model->delete();
            return Yii::$app->getResponse()->redirect(['/user/index']);

        }else{
            throw new NotFoundHttpException('La página solicitada no existe.');
        }


    }else{
        Yii::$app->session->setFlash('error', 'No tienes autorización para ingresar a esta sección.');
        return Yii::$app->getResponse()->redirect(['/site/index']);
    }

    }


    public function actionDetalle($id)
    {

        if ( (User::isUserAdmin(Yii::$app->user->identity->id) == true) ){

        $buscaConcursante = Concursante::find()->where(['id' => $id])->one();

        if($buscaConcursante != null){
        
        return $this->render('detalle', [
                'model' => $buscaConcursante,
            ]);


    }else{
            throw new NotFoundHttpException('La página solicitada no existe.');
        }

    }else{
        Yii::$app->session->setFlash('error', 'No tienes autorización para ingresar a esta sección.');
        return Yii::$app->getResponse()->redirect(['/site/index']);
    }

    }



    public function actionModificaruser($id)
    {
        if ( (User::isUserAdmin(Yii::$app->user->identity->id) == true) ){
        
        $model = new Modificaruser();
        $datosUsuario = $this->findModel($id);
        if($datosUsuario != null){
            $model->username = $datosUsuario->username;
            $model->email = $datosUsuario->email;
            $model->phone = $datosUsuario->phone;
            $model->role = $datosUsuario->role;
            $model->name = $datosUsuario->name;
            if ($model->load(Yii::$app->request->post())) {
                if($user = $model->updateuser($id)){
                    Yii::$app->session->setFlash('success', 'Los datos de la cuenta han sido modificados correctamente.');
                    return Yii::$app->getResponse()->redirect(['/user/index']);                    
                }else{
                    return $this->render('modificaruser', [
                    'model' => $model,
                    ]); 
                }

            }
            return $this->render('modificaruser', [
                'model' => $model,
            ]);


        }else{
            throw new NotFoundHttpException('La página solicitada no existe.');
        }


    }else{
        Yii::$app->session->setFlash('error', 'No tienes autorización para ingresar a esta sección.');
        return Yii::$app->getResponse()->redirect(['/site/index']);
    }

    }


    public function actionCambiarpassword()
    {
if ( (User::isUserAdmin(Yii::$app->user->identity->id) == true) || (User::isUserInformatico(Yii::$app->user->identity->id) == true) || (User::isUserAlcalde(Yii::$app->user->identity->id) == true) || (User::isUserSecretaria(Yii::$app->user->identity->id) == true) ){        
        $id_usuario_actual=\Yii::$app->user->id;
        $model = new Cambiarpassword();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->changepass($id_usuario_actual)) {
                Yii::$app->session->setFlash('success', 'Tu contraseña ha sido cambiada correctamente.');
                return Yii::$app->getResponse()->redirect(['/site/index']);
            }else{
                return $this->render('cambiarpassword', [
                'model' => $model,
                ]); 
            }
        }
            return $this->render('cambiarpassword', [
                'model' => $model,
            ]);

    }else{
        Yii::$app->session->setFlash('error', 'No tienes autorización para ingresar a esta sección.');
        return Yii::$app->getResponse()->redirect(['/site/index']);
    }

    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('La página solicitada no existe.');
        }
    }
}
