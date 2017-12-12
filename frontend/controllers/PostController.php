<?php

namespace frontend\controllers;

use yii\widgets\ListView;
use yii\data\ActiveDataProvider;
use backend\models\Post;

class PostController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionNoticias(){
        $dataProvider = new ActiveDataProvider([
            'query' => Post::find(),
            'pagination' => [
                'pageSize' =>3,
            ],
            'sort' => [
                'defaultOrder' => [
                    'fecha_creacion_post' => SORT_DESC,
                    'titulo_post' => SORT_ASC,

                ],
            ],
        ]);
        return $this->render('index',[
            'dataProvider' => $dataProvider,

        ]);

    }

    public function actionDetalle($id){
        $var = Post::findOne($id);
        if($var != null){
            return $this->render('detalle',[
                'noticia' => $var,

            ]);
        }else{

        }
    }


}
