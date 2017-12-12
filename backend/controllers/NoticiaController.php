<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use backend\models\Noticia;
use backend\models\NoticiaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use lavrentiev\widgets\toastr\Notification;
use backend\models\User;

/**
 * NoticiaController implements the CRUD actions for Noticia model.
 */
class NoticiaController extends Controller
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
                        'actions' => ['principal', 'publicarprincipal', 'secundaria', 'publicarsecundaria', 'terciaria', 'publicarterciaria'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }


    public function actionPrincipal()
    {


    if ( (User::isUserAdmin(Yii::$app->user->identity->id) == true) || (User::isUserInformatico(Yii::$app->user->identity->id) == true) ){

        $buscaNoticia = Noticia::find()->where(['id_noticia' => 1])->one();
        if($buscaNoticia==null){
            $noticia = new Noticia();
            $noticia->save();
            return $this->redirect(['/noticia/principal']);
        }else{
            if ($buscaNoticia->load(Yii::$app->request->post()) && $buscaNoticia->save()) {
                Yii::$app->session->setFlash('success', 'Los datos se han guardado correctamente.');
                return Yii::$app->getResponse()->redirect(['/noticia/principal']);
            }else{
                return $this->render('principal', [
                'model' => $buscaNoticia,
            ]);  
            }
            
        }

    }else{
        Yii::$app->session->setFlash('error', 'No tienes autorización para ingresar a esta sección.');
        return Yii::$app->getResponse()->redirect(['/site/index']);
    }

    }

    public function actionPublicarprincipal()
    {

    if ( (User::isUserAdmin(Yii::$app->user->identity->id) == true) || (User::isUserInformatico(Yii::$app->user->identity->id) == true) ){

        $buscaNoticia = Noticia::find()->where(['id_noticia' => 2])->one();
        $buscaNoticiaGuardada = Noticia::find()->where(['id_noticia' => 1])->one();
        if($buscaNoticia==null){
            $noticia = new Noticia();
            $noticia->noticia_principal = $buscaNoticiaGuardada->noticia_principal;
            $noticia->save();
                Yii::$app->session->setFlash('success', 'Se han publicado los cambios en la página principal.');
                return Yii::$app->getResponse()->redirect(['/noticia/principal']);
        }else{
            $buscaNoticia->noticia_principal = $buscaNoticiaGuardada->noticia_principal;
            $buscaNoticia->save();
                Yii::$app->session->setFlash('success', 'Se han publicado los cambios en la página principal.');
                return Yii::$app->getResponse()->redirect(['/noticia/principal']);
        }

    }else{
        Yii::$app->session->setFlash('error', 'No tienes autorización para ingresar a esta sección.');
        return Yii::$app->getResponse()->redirect(['/site/index']);
    }

    }

    public function actionSecundaria()
    {

    if ( (User::isUserAdmin(Yii::$app->user->identity->id) == true) || (User::isUserInformatico(Yii::$app->user->identity->id) == true) ){

        $buscaNoticia = Noticia::find()->where(['id_noticia' => 1])->one();
        if($buscaNoticia==null){
            $noticia = new Noticia();
            $noticia->save();
            return $this->redirect(['/noticia/secundaria']);
        }else{
            if ($buscaNoticia->load(Yii::$app->request->post()) && $buscaNoticia->save()) {
                Yii::$app->session->setFlash('success', 'Los datos se han guardado correctamente.');
                return Yii::$app->getResponse()->redirect(['/noticia/secundaria']); 
            }else{
                return $this->render('secundaria', [
                'model' => $buscaNoticia,
            ]);  
            }
            
        }

    }else{
        Yii::$app->session->setFlash('error', 'No tienes autorización para ingresar a esta sección.');
        return Yii::$app->getResponse()->redirect(['/site/index']);
    }

    }

    public function actionPublicarsecundaria()
    {

    if ( (User::isUserAdmin(Yii::$app->user->identity->id) == true) || (User::isUserInformatico(Yii::$app->user->identity->id) == true) ){

        $buscaNoticia = Noticia::find()->where(['id_noticia' => 2])->one();
        $buscaNoticiaGuardada = Noticia::find()->where(['id_noticia' => 1])->one();
        if($buscaNoticia==null){
            $noticia = new Noticia();
            $noticia->noticia_secundaria = $buscaNoticiaGuardada->noticia_secundaria;
            $noticia->save();
                Yii::$app->session->setFlash('success', 'Se han publicado los cambios en la página de bases.');
                return Yii::$app->getResponse()->redirect(['/noticia/secundaria']); 
        }else{
            $buscaNoticia->noticia_secundaria = $buscaNoticiaGuardada->noticia_secundaria;
            $buscaNoticia->save();
            Yii::$app->session->setFlash('success', 'Se han publicado los cambios en la página de bases.');
            return Yii::$app->getResponse()->redirect(['/noticia/secundaria']);
        }

    }else{
        Yii::$app->session->setFlash('error', 'No tienes autorización para ingresar a esta sección.');
        return Yii::$app->getResponse()->redirect(['/site/index']);
    }

    }

    public function actionTerciaria()
    {

    if ( (User::isUserAdmin(Yii::$app->user->identity->id) == true) || (User::isUserInformatico(Yii::$app->user->identity->id) == true) ){

        $buscaNoticia = Noticia::find()->where(['id_noticia' => 1])->one();
        if($buscaNoticia==null){
            $noticia = new Noticia();
            $noticia->save();
            return $this->redirect(['/noticia/terciaria']);
        }else{
            if ($buscaNoticia->load(Yii::$app->request->post()) && $buscaNoticia->save()) {
                Yii::$app->session->setFlash('success', 'Los datos se han guardado correctamente.');
                return Yii::$app->getResponse()->redirect(['/noticia/terciaria']); 
            }else{
                return $this->render('terciaria', [
                'model' => $buscaNoticia,
            ]);  
            }
            
        }

    }else{
        Yii::$app->session->setFlash('error', 'No tienes autorización para ingresar a esta sección.');
        return Yii::$app->getResponse()->redirect(['/site/index']);
    }

    }

    public function actionPublicarterciaria()
    {

    if ( (User::isUserAdmin(Yii::$app->user->identity->id) == true) || (User::isUserInformatico(Yii::$app->user->identity->id) == true) ){
        
        $buscaNoticia = Noticia::find()->where(['id_noticia' => 2])->one();
        $buscaNoticiaGuardada = Noticia::find()->where(['id_noticia' => 1])->one();
        if($buscaNoticia==null){
            $noticia = new Noticia();
            $noticia->noticia_principal = $buscaNoticiaGuardada->noticia_terciaria;
            $noticia->save();
                Yii::$app->session->setFlash('success', 'Se han publicado los cambios en la página de preguntas frecuentes.');
                return Yii::$app->getResponse()->redirect(['/noticia/terciaria']); 
        }else{
            $buscaNoticia->noticia_terciaria = $buscaNoticiaGuardada->noticia_terciaria;
            $buscaNoticia->save();
            Yii::$app->session->setFlash('success', 'Se han publicado los cambios en la página de preguntas frecuentes.');
            return Yii::$app->getResponse()->redirect(['/noticia/terciaria']);
        }

    }else{
        Yii::$app->session->setFlash('error', 'No tienes autorización para ingresar a esta sección.');
        return Yii::$app->getResponse()->redirect(['/site/index']);
    }

    }        
}
