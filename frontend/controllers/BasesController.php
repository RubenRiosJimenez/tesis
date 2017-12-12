<?php
/**
 * Created by PhpStorm.
 * User: Rubén
 * Date: 02-12-2017
 * Time: 19:35
 */

namespace frontend\controllers;

use yii\widgets\ListView;
use yii\data\ActiveDataProvider;
use backend\models\bases;

class BasesController extends \yii\web\Controller
{

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => bases::find(),
            'pagination' => [
                'pageSize' =>3,
            ],
            'sort' => [
                'defaultOrder' => [
                    'fecha_creacion_base' => SORT_DESC,


                ],
            ],
        ]);
        return $this->render('index',[
            'dataProvider' => $dataProvider,

        ]);
    }

    public function actionBases(){
        $dataProvider = new ActiveDataProvider([
            'query' => bases::find(),
            'pagination' => [
                'pageSize' =>3,
            ],


        ]);
        return $this->render('index',[
            'dataProvider' => $dataProvider,

        ]);

    }

    public function actionDetalle($id){
        $var = bases::findOne($id);
        if($var != null){
            return $this->render('detalle',[
                'bases' => $var,

            ]);
        }else{

        }
    }

}