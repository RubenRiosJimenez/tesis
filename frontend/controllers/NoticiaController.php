<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Noticia;
use frontend\models\NoticiaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use lavrentiev\widgets\toastr\Notification;

/**
 * NoticiaController implements the CRUD actions for Noticia model.
 */
class NoticiaController extends Controller
{
    /**
     * @inheritdoc
     */

    public function actionPrevisualizarprincipal()
    {
        $buscaNoticia = Noticia::find()->where(['id_noticia' => 1])->one();
            return $this->render('previsualizarprincipal', [
            'model' => $buscaNoticia,
            ]);
    }


    public function actionPrevisualizarsecundaria()
    {
        $buscaNoticia = Noticia::find()->where(['id_noticia' => 1])->one();
            return $this->render('previsualizarsecundaria', [
            'model' => $buscaNoticia,
            ]);
    }


    public function actionPrevisualizarterciaria()
    {
        $buscaNoticia = Noticia::find()->where(['id_noticia' => 1])->one();
            return $this->render('previsualizarterciaria', [
            'model' => $buscaNoticia,
            ]);
    }        


}
