<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use backend\models\Convocatoria;
use backend\models\Concursante;
use backend\models\Formulario;

use backend\models\Estadopostulacion;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\PostulacionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Postulaciones:');
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
                    <td><center><h1>Postulaciones</h1><br>


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



        $id_estadopostulacion= $searchModel->id_estadopostulacion;

        if(isset($id_estadopostulacion)){
            $estadopostulacion= Estadopostulacion::find()->where(['id_estadopostulacion'=>$id_estadopostulacion])->one();

            if (isset($estadopostulacion)) {
                echo '<br> <strong>Estado de la postulación:</strong>&nbsp;&nbsp;&nbsp;'.$estadopostulacion->nombre_estadopostulacion.'';
                # code...
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





<div class="postulacion-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
  


<br>
<br>
<div style="overflow: auto;">
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
                [
                'attribute' => 'convocatoria',
                'label' => 'Convocatoria',
                'value'=>'convocatoria.nombreConvocatoria',
                'headerOptions' => ['class' => 'text-center'],
                'filter'=>Html::activeDropDownList($searchModel,'id_convocatoria',ArrayHelper::map(Convocatoria::find()->asArray()->all(), 'id_convocatoria','nombreConvocatoria'),['class'=>'form-control','prompt'=>'Filtrar']),
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
            'attribute' => 'montoAsignado',
            'label' => 'Monto asignado ($)',
            'contentOptions' => ['class' => 'text-center'],
            'headerOptions' => ['class' => 'text-center'],
            'value'=>function($data){
                    if($data->montoAsignado==null){
                        return 'Sin asignación';
                    }else{
                        return '$'.number_format($data->montoAsignado, 0, ",", ".");
                    }        
            }
            ],    
                 [
            'attribute' => 'financiamiento_aporte_solicitado',
            'label' => 'Monto solicitado ($)',
            'contentOptions' => ['class' => 'text-center'],
            'headerOptions' => ['class' => 'text-center'],
            'value'=>function($data){
                    if($data->formulario->financiamiento_aporte_solicitado==null){
                        return 'No se ha solicitado';
                    }else{
                        return '$'.number_format($data->formulario->financiamiento_aporte_solicitado, 0, ",", ".");
                    }        
            }
            ],                                                       

            
[
                'attribute' => 'estadopostulacion',
                'label' => 'Estado de la postulación',
                'contentOptions' => ['class' => 'text-center'],
                'format' => 'html',
                                'value'=>function($data){
                                    switch($data->id_estadopostulacion){
                                        case 1:
                                        return Html::tag('span', '&nbsp;'.$data->estadopostulacion->nombre_estadopostulacion.'&nbsp;', ['class' => 'label label-danger', 'style'=>'font-size: 12px;']);
                                        break;
                                        case 2:
                                        return Html::tag('span', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$data->estadopostulacion->nombre_estadopostulacion.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', ['class' => 'label label-success', 'style'=>' font-size: 12px;']);
                                        break;
                                        case 3:
                                        return Html::tag('span', '&nbsp;&nbsp;&nbsp;&nbsp;'.$data->estadopostulacion->nombre_estadopostulacion.'&nbsp;&nbsp;&nbsp;&nbsp;', ['class' => 'label label-primary', 'style'=>' font-size: 12px;']);
                                        break;
                                        case 4:
                                        return Html::tag('span','&nbsp;'.$data->estadopostulacion->nombre_estadopostulacion, ['class' => 'label label-warning', 'style'=>' font-size: 12px;']);
                                        break;                                                                       
                                    }
                                },
                'headerOptions' => ['class' => 'text-center', 'style' => 'font-weight: bold'],
                'filter'=>Html::activeDropDownList($searchModel,'id_estadopostulacion',ArrayHelper::map(Estadopostulacion::find()->asArray()->all(), 'id_estadopostulacion','nombre_estadopostulacion'),['class'=>'form-control','prompt'=>'Filtrar']),
                                      'visible' => !isset($estadopostulacion),

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
          
        ],
    ]); ?>
<?php Pjax::end(); ?>
    
</div>

