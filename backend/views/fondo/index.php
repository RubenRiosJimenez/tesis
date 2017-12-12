<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\fondo;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\FondoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Fondos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fondo-index">


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?= 'Ingrese criterios de filtrado: ' ?>

<?php Pjax::begin(); ?>    <?= GridView::widget([

        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,

        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],


            'nombre_fondo',
            'nombre_estado',
            'observacion_fondo:ntext',
            'fecha_creacion',

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{Modificar} {Ver}',
                'options'=> ['style'=>'min-width:150px;'],
                'buttons' => [
                    'Eliminar'=>function($url,$model,$key){


                     return  Html::a(Yii::t('app', '<span class="glyphicon glyphicon-trash"></span>'), ['delete', 'id' => $model->id_fondo], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => Yii::t('app', '¿Está seguro de eliminar este fondo?'),
                                'method' => 'post',
                            ],
                        ]);



                    },

                    'Modificar'=>function($url,$model,$key){


                            return
                                Html::a(Yii::t('app', '<span class="glyphicon glyphicon-edit"></span>'), ['update', 'id' => $model->id_fondo], ['class' => 'btn btn-primary']);


                    },
                    'Ver'=>function($url,$model,$key){


                        return
                            Html::a(Yii::t('app', '<span class="glyphicon glyphicon-eye-open"></span>'), ['view', 'id' => $model->id_fondo], ['class' => 'btn btn-primary']);


                    },
                    

            ],
        ],
],
    ]); ?>
    <p>
        <?= Html::a(Yii::t('app', 'Crear Fondo'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::end(); ?></div>
