<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use backend\models\Convocatoria;
use backend\models\Estadopostulacion;
use backend\models\Evaluacion;
use backend\models\Estadoevaluacion;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PostulacionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Evaluación:';
?>

<div id="header">   
        <div id="head-content" class="clearfix ">
            <table>
                <tr>
                    <td><img src=".././web/recursos/img/escudo_yungay_opt.png" /></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>       
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>       
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><center><h1>Postulaciones en evaluación</h1><br>


                        <br>
                        <ul>
        <?php
            $id_convocatoria=$searchModel->id_convocatoria;

          if(isset($id_convocatoria)){

             $convocatoria= Convocatoria::find()->where(['id_convocatoria'=>$id_convocatoria])->one();
             if(isset($convocatoria)){
                  echo '<center><h2><strong>'.$convocatoria->nombreConvocatoria.'</strong></h2></center>';
             }
          
        }



         $estadoEvaluacion=$searchModel->estadoEvaluacion;

        if(isset($estadoEvaluacion)){
            $estado= Estadoevaluacion::find()->where(['id_estado'=>$estadoEvaluacion])->one();

            if (isset($estado)) {
                echo '<br> <strong>Estado de la evaluación:</strong>&nbsp;&nbsp;&nbsp;'.$estado->descripcion_estado.'';
                # code...
            }
            
        }

    ?>


    </ul>

                    </center></td>

                </tr>


                <tr>

              </tr>
            </table>                 
             
        
        </div>  
    </div>
    <br>
  
  


<br>
<br>
<div style="overflow: auto;">
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],


            [
                'attribute' => 'convocatoria',
                'label' => 'Convocatoria',
                'value'=>'convocatoria.nombreConvocatoria',
                'headerOptions' => ['class' => 'text-center'],
                'filter'=>Html::activeDropDownList($searchModel,'id_convocatoria',ArrayHelper::map(Convocatoria::find()->where(['id_estadoConvocatoria' => 2])->asArray()->all(), 'id_convocatoria','nombreConvocatoria'),['class'=>'form-control','prompt'=>'Filtrar']),
                'visible' => !isset($convocatoria),
            ],

             [
            'attribute' => 'concursante',
            'label' => 'Concursante',
            'headerOptions' => ['class' => 'text-center'],
            'value'=>'concursante.nombreConcursante'
            ],

             [
            'attribute' => 'rutConcursante',
            'label' => 'Rut',
            'contentOptions' => ['class' => 'text-center'],
            'headerOptions' => ['class' => 'text-center'],
            'value'=>'concursante.rut'
            ],
            [
            'attribute' => 'nombreOrganizacion',
            'label' => 'Organización',
            'headerOptions' => ['class' => 'text-center'],
            'value'=>function($data){
                    if($data->formulario->nombre_organizacion==null){
                        return 'Sin nombre';
                    }else{
                        return $data->formulario->nombre_organizacion;
                    }        
            }
            ],
            [
            'attribute' => 'nombreProyecto',
            'label' => 'Proyecto',
            'headerOptions' => ['class' => 'text-center'],
            'value'=>function($data){
                    if($data->formulario->nombre_proyecto==null){
                        return 'Sin nombre';
                    }else{
                        return $data->formulario->nombre_proyecto;
                    }        
            }
            ],


            [
            'attribute' => 'fecha_postulacion',
            'label' => 'Fecha de postulación',
            'contentOptions' => ['class' => 'text-center'],
            'headerOptions' => ['class' => 'text-center'],
                'value'=>function($data){
                    if($data->fecha_postulacion==''){
                        return 'Sin fecha';
                    }else{
                        return date('d-m-Y',strtotime($data->fecha_postulacion));
                    }


                    
            }
            ],
             [
                'attribute' => 'estadoEvaluacion',
                'label' => 'Estado de la evaluación',
                'contentOptions' => ['class' => 'text-center'],
                'format' => 'html',
                                'value'=>function($data){
                                    $buscaEstadoEvaluacion = Estadoevaluacion::find()->all();                                    
                                    switch($data->evaluacion->id_estado){
                                        case 1:
                                        $buscaEstadoEvaluacion = Estadoevaluacion::find()->where(['id_estado' => 1])->one();
                                        return Html::tag('span',$buscaEstadoEvaluacion->descripcion_estado, ['class' => 'label label-warning', 'style'=>'font-size: 12px;']);
                                        break;
                                        case 2:
                                        $buscaEstadoEvaluacion = Estadoevaluacion::find()->where(['id_estado' => 2])->one();
                                        return Html::tag('span', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$buscaEstadoEvaluacion->descripcion_estado.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', ['class' => 'label label-danger', 'style'=>' font-size: 12px;']);
                                        break;
                                        case 3:
                                        $buscaEstadoEvaluacion = Estadoevaluacion::find()->where(['id_estado' => 3])->one();
                                        return Html::tag('span', '&nbsp;&nbsp;&nbsp;&nbsp;'.$buscaEstadoEvaluacion->descripcion_estado.'&nbsp;&nbsp;&nbsp;&nbsp;', ['class' => 'label label-primary', 'style'=>' font-size: 12px;']);
                                        break;                                                                      
                                    }
                                },
                'headerOptions' => ['class' => 'text-center'],
                'filter'=>Html::activeDropDownList($searchModel,'estadoEvaluacion',ArrayHelper::map(Estadoevaluacion::find()->where(['<','id_estado', 3])->asArray()->all(), 'id_estado','descripcion_estado'),['class'=>'form-control','prompt'=>'Filtrar']),
                          'visible' => !isset($estado),

            ],            

            [
                'attribute' => 'puntaje_1',
                'label'=>'Puntaje',
                'headerOptions' => ['class' => 'text-center'],                
            'contentOptions' =>function ($model, $key, $index, $column){
                    return ['class' => 'tbl_column_name text-center'];
            },

            'value'=>function ($data) {
                if($data->evaluacion->puntaje_1 == null){
                    return 'Sin asignación de puntaje';
                }else{
                    if($data->evaluacion->puntaje_1 == 1){
                        return $data->evaluacion->puntaje_1.' punto';
                    }else{
                        return $data->evaluacion->puntaje_1.' puntos';
                    }

                }
            },
            ],            
 
          
        ],
    ]); ?>
<?php Pjax::end(); ?>


</div>
