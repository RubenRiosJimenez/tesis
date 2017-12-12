<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Usuarios en el sistema:');
?>
<div class="user-index">

<br>

    <p>
        <?= Html::a(Yii::t('app', 'Agregar usuario'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <br>
        <div style="overflow: auto;">
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

             [
            'attribute' => 'username',
            'label' => 'Nombre de usuario',
            'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' =>function ($model, $key, $index, $column){
                    return ['class' => 'tbl_column_name', 'style' => 'max-width: 300px; word-wrap: break-word;'];
            },
            'value'=>'username'
            ],

            [
                'attribute' => 'role',
                'label' => 'Perfil',
                'contentOptions' => ['class' => 'text-center'],
                'format' => 'html',
                                'value'=>function($data){
                                    if($data->role == 1){
                                        return 'Administrador';
                                    }else{
                                        if($data->role == 2){
                                            return 'Informático';
                                        }else{
                                            if($data->role == 3){
                                                return 'Alcalde';
                                            }else{
                                                if($data->role == 4){
                                                    return 'Secretaria/o';
                                                }else{
                                                    if($data->role ==5){
                                                        return 'Concursante';
                                                    }
                                                }
                                            }
                                        }
                                    }
                                },
                'headerOptions' => ['class' => 'text-center', 'style' => 'font-weight: bold'],
                'filter'=>Html::activeDropDownList($searchModel,'role',array('1' => 'Administrador', '2' => 'Informático', '3' => 'Alcalde', '4' => 'Secretaria/o', '5' => 'Concursante'),['class'=>'form-control','prompt'=>'Filtrar']),
            ],



             [
            'attribute' => 'name',
            'label' => 'Nombre',
            'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' =>function ($model, $key, $index, $column){
                    return ['class' => 'tbl_column_name', 'style' => 'max-width: 300px; word-wrap: break-word;'];
            },
            'value'=>'name'
            ],

             [
            'attribute' => 'phone',
            'label' => 'Teléfono',
            'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' =>function ($model, $key, $index, $column){
                    return ['class' => 'tbl_column_name text-center', 'style' => 'max-width: 300px; word-wrap: break-word;'];
            },
            'value'=>'phone'
            ],

            [
                'attribute' => 'status',
                'label' => 'Estado de la cuenta',
                'contentOptions' => ['class' => 'text-center'],
                'format' => 'html',
                                'value'=>function($data){
                                    switch($data->status){
                                        case 0:
                                        return Html::tag('span', 'Bloqueada', ['class' => 'label label-danger', 'style'=>'font-size: 12px;']);
                                        break;
                                        case 10:
                                        return Html::tag('span', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Activa&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', ['class' => 'label label-primary', 'style'=>' font-size: 12px;']);
                                        break;                                                                      
                                    }
                                },
                'headerOptions' => ['class' => 'text-center', 'style' => 'font-weight: bold'],
                'filter'=>Html::activeDropDownList($searchModel,'status',array('0' => 'Bloqueada', '10' => 'Activa'),['class'=>'form-control','prompt'=>'Filtrar']),
            ],



          ['class' => 'yii\grid\ActionColumn',
            'template' => '{estado} {modificar} {delete} {detalle} {correo}',
            'options'=> ['style'=>'min-width:150px;'],
            'buttons' => ['estado'=>function($url,$model,$key){
                if(\Yii::$app->user->id != $model->id){

                return Html::a('<span class="glyphicon glyphicon-ban-circle"></span>',

['/user/estado','id' => $model->id] ,['title' => Yii::t('yii', 'Cambiar estado de la cuenta'),'aria-label' => Yii::t('yii', 'Cambiar estado de la cuenta'), 'class'=>'btn btn-warning', 'data-confirm' => Yii::t('yii', '¿Estás seguro que deseas cambiar el estado de la cuenta?'),'data-method' => 'post','data-pjax' => '0',] );
            }
        },

'modificar'=>function($url,$model,$key){
    if($model->role < 5){
                return Html::a('<span class="glyphicon glyphicon-edit"></span>',

['/user/modificaruser','id' => $model->id],['title' => Yii::t('yii', 'Modificar usuario'),'aria-label' => Yii::t('yii', 'Modificar usuario'), 'class'=>'btn btn-success','data-pjax' => '0',] );
            }
            }, 

'detalle'=>function($url,$model,$key){
    if($model->role == 5){
                return Html::a('<span class="glyphicon glyphicon-tag"></span>',

['/user/detalle','id' => $model->id],['title' => Yii::t('yii', 'Ver detalle del usuario'),'aria-label' => Yii::t('yii', 'Ver detalle del usuario'), 'class'=>'btn btn-info','data-pjax' => '0',] );
            }
            }, 




'delete'=>function($url,$model,$key){
    if($model->role < 5 && (\Yii::$app->user->id != $model->id)){
                return Html::a('<span class="glyphicon glyphicon-trash"></span>',

['/user/delete','id' => $model->id],['title' => Yii::t('yii', 'Eliminar cuenta de usuario'),'aria-label' => Yii::t('yii', 'Eliminar cuenta de usuario'), 'class'=>'btn btn-danger', 'data-confirm' => Yii::t('yii', '¿Estas seguro que deseas eliminar esta cuenta de usuario?'),'data-method' => 'post','data-pjax' => '0',] );
            }
            },  




'correo'=>function($url,$model,$key){
    if((\Yii::$app->user->id != $model->id)){
                return Html::a('<span class="glyphicon glyphicon-envelope"></span>',

['/user/enviarcorreo','id' => $model->id],['title' => Yii::t('yii', 'Redactar correo personalizado'),'aria-label' => Yii::t('yii', 'Redactar correo personalizado'), 'class'=>'btn btn-primary','data-pjax' => '0',] );
            }
            }, 


            ],
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?>
    </div>
</div>
