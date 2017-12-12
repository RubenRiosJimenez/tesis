<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\postSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel backend\models\FondoSearch */

$this->title = Yii::t('app', 'Publicaciones');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Crear Publicación'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'titulo_post',
            'fecha_creacion_post',
            // 'id_fondo',


            ['class' => 'yii\grid\ActionColumn',
                'template' => '{Eliminar} {Modificar} {Ver}',
                'options'=> ['style'=>'min-width:150px;'],
                'buttons' => [
                    'Eliminar'=>function($url,$model,$key){


                        return  Html::a(Yii::t('app', '<span class="glyphicon glyphicon-trash"></span>'), ['delete', 'id' => $model->id_post], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => Yii::t('app', '¿Está seguro de eliminar esta publicación?'),
                                'method' => 'post',
                            ],
                        ]);



                    },

                    'Modificar'=>function($url,$model,$key){


                        return
                            Html::a(Yii::t('app', '<span class="glyphicon glyphicon-edit"></span>'), ['update', 'id' => $model->id_post], ['class' => 'btn btn-primary']);


                    },
                    'Ver'=>function($url,$model,$key){


                        return
                            Html::a(Yii::t('app', '<span class="glyphicon glyphicon-eye-open"></span>'), ['view', 'id' => $model->id_post], ['class' => 'btn btn-primary']);


                    },


                ],

            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
