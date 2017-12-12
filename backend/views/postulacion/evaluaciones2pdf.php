<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use backend\models\Convocatoria;
use backend\models\Estadopostulacion;
use backend\models\Evaluacion;
use backend\models\Resultado;
use backend\models\Estadoresultado;

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
                    
                    
                                             <td><center><h1>Postulaciones pre-seleccionadas</h1><br>


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

    ?>


    </ul>

                    </center></td>
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
       // 'filterModel' => $searchModel,
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
                'label' => 'Estado de la asignación',
                'contentOptions' => ['class' => 'text-center'],
                'format' => 'html',
                                'value'=>function($data){
                                    $buscaResultado = Resultado::find()->where(['id_evaluacion' => $data->evaluacion->id_evaluacion])->one();
                                    if($buscaResultado != null){
                                    $buscaEstadoResultado = Estadoresultado::find()->where(['id_estado' => $buscaResultado->id_estado])->one();
                                    }                                    
                                    if($buscaResultado == null || $buscaResultado->id_estado == 1){
                                        return Html::tag('span','Pendiente de revisión', ['class' => 'label label-warning', 'style'=>'font-size: 12px;']);
                                    }else{
                                        return Html::tag('span','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$buscaEstadoResultado->descripcion_estado.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', ['class' => 'label label-danger', 'style'=>'font-size: 12px;']);
                                    }                                                                
                                },
                'headerOptions' => ['class' => 'text-center'],
            ],              

            [
                'attribute' => 'total',
                'label'=>'Puntaje final',
                'headerOptions' => ['class' => 'text-center'],                
            'contentOptions' =>function ($model, $key, $index, $column){
                    return ['class' => 'tbl_column_name text-center'];
            },

            'value'=>function ($data) {
                    return $data->evaluacion->puntaje_1 + $data->evaluacion->puntaje_2 + $data->evaluacion->puntaje_3 .' puntos';

            },
            ],           
 
                    ],
    ]); ?>
<?php Pjax::end(); ?>
    </div>