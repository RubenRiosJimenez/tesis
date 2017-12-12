<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use himiklab\ckeditor\CKEditor;
use kartik\date\DatePicker;
use kartik\mpdf\Pdf;
use frontend\models\Formulario;
use frontend\models\Postulacion;

use frontend\models\Tablapresupuesto;
use frontend\models\Tablaitemfinanciamiento;
use frontend\models\Tablacartagantt;


$tablapresupuesto= Tablapresupuesto::find()->where(['id_formulario' =>$model->id_formulario])->all();
$tablaitemfinanciamiento= Tablaitemfinanciamiento::find()->where(['id_formulario' =>$model->id_formulario])->all();
$tablacartagantt= Tablacartagantt::find()->where(['id_formulario' =>$model->id_formulario])->all();
$buscaPostulacion = Postulacion::find()->where(['id_postulacion' => $model->id_formulario])->one();
$fecha_presentacion=$buscaPostulacion->fecha_postulacion;
$fecha_presentacionformateada=date('d-m-Y',strtotime($fecha_presentacion));
$fecha_personalidadjuridica=$model->fecha_personalidadJuridica ;
$fecha_personalidadjuridicaformateada= date('d-m-Y',strtotime($fecha_personalidadjuridica));

?>

<html>
<head>
</head>
<body>
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
                    <td><h1>Formulario de postulación</h1><br><center><h3>Subvención municipal año <?php echo date('Y'); ?></h3></center><br></td>
                    <td><br><br><br><br><br><br>Número: <?= $model->id_formulario ?></td>
                </tr>
            </table>                 
             
                            
        </div>  
    </div>
    <br>


    <div class="row">

        <div class="col-lg-5">
             <font size="3">   Fecha de la presentación: <?= $fecha_presentacionformateada ?> </font>
                <br>
                <h4>Antecedentes de la institución:</h4>
                <table>
                    <tr>
                        <td> <font size="3"> Nombre de la organización </font></td>
                        <td>:&nbsp;&nbsp;&nbsp;<font size="3"><?= $model->nombre_organizacion ?></font></td>
                    </tr>

                    <tr>
                       <td> <font size="3">Número del rut de la organización</font></td>
                        <td>:&nbsp;&nbsp;&nbsp;<font size="3"><?= $model->rut_organizacion ?> </font></td>
                    </tr>
             

                    <tr>
                        <td> <font size="3">Número de la personalidad jurídica</font></td>
                        <td>:&nbsp;&nbsp;&nbsp;<font size="3"><?= $model->numero_personalidadJuridica ?></font> </td>
                       
                    </tr>
                    <tr>
                        <td><font size="3">Fecha de la personalidad jurídica</font></td>
                        <td>:&nbsp;&nbsp;&nbsp;<font size="3"><?= $fecha_personalidadjuridicaformateada ?></font></td>
                    </tr>
                   <tr>
                        <td><font size="3">Otorgada por</font></td>
                        <td>:&nbsp;&nbsp;&nbsp;<font size="3"><?= $model->organismoQueOtorgo_personalidadJuridica ?></font></td>
                   </tr>

                </table>
                
                
              
               
                <br>
                <h4>Objetivos generales de la organización: </h4>
        
               <font size="3"> <?= $model->objetivos_generalesOrganizacion ?></font>
                <br>
                <h4>Fuentes de financiamiento que posee la institución:</h4>
               <font size="3"> <?= $model->financiamiento_organizacion ?></font>
                <br>
                <h4>Identificación del representante legal de la institución:</h4>
                <table>
                    <tr>
                        <td><font size="3">Nombre</font></td>
                        <td>:&nbsp;&nbsp;&nbsp;<font size="3"><?= $model->nombre_representanteLegal ?></font></td>

                    </tr>
                    <tr>
                        <td><font size="3">Rut</font></td>
                        <td>:&nbsp;&nbsp;&nbsp;<font size="3"><?= $model->numeroRut_representanteLegal?></font></td>
                    </tr>
                    <tr>
                        <td><font size="3">Teléfono:</font></td>
                        <td>:&nbsp;&nbsp;&nbsp;<font size="3"><?= $model->telefono_contacto?></font></td>
                    
                    </tr>
                    <tr>
                        <td><font size="3">Domicilio</font></td>
                        <td>:&nbsp;&nbsp;&nbsp;<font size="3"><?= $model->domiciolio_representanteLegal?></font></td>
                    </tr>
                </table>
                <br>
                <h4>Área de la subvención:</h4>
                <?= $model->area_subvencion?> 
                <br>
                <?php 
                    if($model->area_subvencion=='Otra'){
                        echo 'Descripción:';
                        echo $model->otra_subvencion;
                    }
                ?>
                <br>
               <h4>Identificación del proyecto o programa:</h4>
               <table>
                    <tr>
                        <td><font size="3">Nombre del proyecto</font></td>
                        <td>:&nbsp;&nbsp;&nbsp;<font size="3"><?= $model->nombre_proyecto?></font></td>

                    </tr>
                    <tr>
                        <font size="3">Localización del proyecto o programa:</font>

                    </tr>

                    <tr>
                        <td><font size="3">Número de la unidad Vecinal</font></td>
                        <td>:&nbsp;&nbsp;&nbsp;<font size="3"><?= $model->numero_unidadVecinal ?></font></td>
                    </tr>
                    <tr>
                        <td><font size="3">Dirección del proyecto</td>
                        <td>:&nbsp;&nbsp;&nbsp;<font size="3"><?= $model->direccion_proyecto ?></font></td>
                    
                    </tr>
               </table>
               <br>
               <h4>Objetivos del proyecto:</h4>
                <?= $model->objetivos_proyecto?>
               <br>
               <h4>Descripción del proyecto:</h4>
               <?= $model->descripcion_proyecto?>
               <h4>Número de beneficiarios:</h4>
               <table>
                    <tr>
                        <td><font size="3">Número de beneficiarios directos</font></td>
                        <td>:&nbsp;&nbsp;&nbsp;<font size="3"><?= $model->numero_beneficiariosDirectos ?></font></td>
                    </tr>
                    <tr>
                        <td><font size="3">Número de beneficiarios indirectos</font></td>
                        <td>:&nbsp;&nbsp;&nbsp;<font size="3"><?= $model->numero_beneficiariosIndirectos ?></font></td>
                    
                    </tr>
               </table>
               <br>
               <h4>Descripción de los beneficiarios directos del proyecto:</h4>
               <?= $model->descripcion_beneficiariosDirectos ?>
               <br>

               <h4>Presupuesto detallado del proyecto o programa:</h4>
                        <table border=1 cellspacing=0 cellpadding="10px">
                    <tr>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Precio unitario($)</th>
                        <th>Costo total($)</th>

                    </tr>

                    <?php
                        $total=0;
                        foreach($tablapresupuesto as $presupuesto){
                    ?>
                        <tr>
                            <td><?= $presupuesto->descripcion ?></td>
                            <td><?= $presupuesto->cantidad ?> </td>
                            <td><?= $presupuesto->precioUnitario ?> </td>
                            <td><?= $presupuesto->costoTotal ?> </td>   
                        </tr>

                    <?php     

                        $total+= $presupuesto->costoTotal;  

                        }


                    ?>


               </table>

               <table cellpadding="10px">

                    <tr>

                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>Total($):</th>
                        <th><?php echo $total; ?></th>
                    </tr>


               </table>

               <br>
                <h4>Que se financiará con la subvención municipal:</h4>
                        <table border=1 cellspacing=0 cellpadding="10px">
                    <tr>
                        <th>Descripción</th>
                        <th>Monto($)</th>

                    </tr>

                    <?php
                       
                        foreach($tablaitemfinanciamiento as $financiamiento){
                    ?>
                        <tr>
                            <td><?= $financiamiento->descripcion ?></td>
                            <td><?= $financiamiento->monto ?> </td>
                         
                        </tr>

                    <?php     


                        }


                    ?>


               </table>

               <br>
                <h4>Financiamiento del proyecto:</h4>
               <table>
                <tr>
                    <td><font size="3">Aporte propio($)</font></td>
                    <td>:&nbsp;&nbsp;&nbsp;<font size="3"><?= $model->financiamiento_aporte_propio ?></font></td>
                </tr>
                <tr>
                    <td><font size="3">Aporte de terceros($)</td>
                    <td>:&nbsp;&nbsp;&nbsp;<font size="3"><?= $model->financiamiento_aporte_terceros ?></font></td>
                </tr> 
                <tr>
                    <td><font size="3">Aporte solicitado($)</td>
                    <td>:&nbsp;&nbsp;&nbsp;<font size="3"><?= $model->financiamiento_aporte_solicitado ?></font></td>
                </tr> <tr>
                    <td><font size="3">Costo total del proyecto($)</td>
                    <td>:&nbsp;&nbsp;&nbsp;<font size="3"><?= $model->financiamiento_aporteTotal_proyecto ?></font></td>
                </tr>




               </table>

               <br>
               <h4>Carta Gantt:</h4>
                        <table border=1 cellspacing=0 cellpadding="10px">
                    <tr>
                        <th>Mes</th>
                        <th>Actividad</th>

                    </tr>

                    <?php
                        
                        foreach($tablacartagantt as $actividad){
                    ?>
                        <tr>
                            <td><?= $actividad->mes ?> </td>
                            <td><?= $actividad->descripcion ?></td>
                   
                         
                        </tr>

                    <?php     


                        }


                    ?>


               </table>

            
        </div>
       
    </div>
     
</body>

</html>