<?php

namespace backend\controllers;

use Yii;
use backend\models\post;
use backend\models\postSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use lavrentiev\widgets\toastr\Notification;
use backend\models\User;

/**
 * PostController implements the CRUD actions for post model.
 */
class PostController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [

            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => ['principal', 'publicarprincipal',
                    'delete' => ['POST'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],
        ];
    }

    /**
     * Lists all post models.
     * @return mixed
     */

    public function actionPrincipal()
    {


        if ( (User::isUserAdmin(Yii::$app->user->identity->id) == true) || (User::isUserInformatico(Yii::$app->user->identity->id) == true) ){

            $buscaPost = post::find()->where(['id_post' => 1])->one();
            if($buscaPost==null){
                $post = new post();
                $post->save();
                return $this->redirect(['/post/principal']);
            }else{
                if ($buscaPost->load(Yii::$app->request->post()) && $buscaPost->save()) {
                    Yii::$app->session->setFlash('success', 'Los datos se han guardado correctamente.');
                    return Yii::$app->getResponse()->redirect(['/post/principal']);
                }else{
                    return $this->render('principal', [
                        'model' => $buscaPost,
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
    public function actionIndex()
    {
        $searchModel = new postSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single post model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new post();

        if ($model->load(Yii::$app->request->post())) {
            $image = UploadedFile::getInstance($model, 'imagen_Post');

            if (isset($image)){
                $fecha = new \DateTime();
                $noticiaId = $fecha->getTimestamp();
                $imgName='not_'.$noticiaId. '.' . $image->getExtension();
                $image->saveAs(Yii::getAlias('@noticiaImgPath').'/'.$imgName);
                $model->imagen_Post = $imgName;
                $model->id_tipoPost = 2;
                $model->save();
            }else{
                $model->id_tipoPost = 2;
                $model->save();
            }
            return $this->redirect(['view', 'id' => $model->id_post]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }



        }



    public function actionUpdate($id)
    {
        $model = $this->findModel($id);


        $imagen_anterior = $model->imagen_Post;

        if ($model->load(Yii::$app->request->post())) {

            // fijarse si viene seteada la imagen
            //si viene se actualiza
            /*echo "<pre>";
            echo print_r(UploadedFile::getInstance($model, 'imagen_Post'));
            echo "</pre>";
            die();*/
            $image = UploadedFile::getInstance($model, 'imagen_Post');

            if (isset($image)){
                $fecha = new \DateTime();
                $noticiaId = $fecha->getTimestamp();
                $imgName='not_'.$noticiaId. '.' . $image->getExtension();
                $image->saveAs(Yii::getAlias('@noticiaImgPath').'/'.$imgName);
                $model->imagen_Post = $imgName;
            }else{
                $model->imagen_Post = $imagen_anterior;
            }
            //si no se deja la que estaba en bd
            $model->save();

            return $this->redirect(['view', 'id' => $model->id_post]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = post::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
