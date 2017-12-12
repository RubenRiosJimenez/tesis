<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use backend\models\Fondo;
/* @var $this yii\web\View */
/* @var $model backend\models\Convocatoria */
/* @var $model backend\models\Fondo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="convocatoria-form">

    <?php $form = ActiveForm::begin(['id' => 'convocatoria-form', 'options' => ['data-pjax' => true]]); ?>
    <div class="row">
 <div class="col-lg-12">
<h4 style="color:#a94442;">Dado a que se han realizado postulaciones en esta convocatoria, la fecha de inicio no es editable.</h4>

        </div>

</div>
<br>
               
    <div class="row">

        <div class="col-lg-3">
            <?= $form->field($model, 'nombreConvocatoria')->textInput(['maxlength' => true]) ?>

        </div>
        <div class="col-lg-3">
        <?= $form->field($model, 'montoConvocatoria')->textInput(['maxlength'=>9]) ?>
        </div>

        <div class="col-lg-3">

            <?php echo $form->field($model, 'id_fondo')->dropDownList( $var = \yii\helpers\ArrayHelper :: map(fondo :: find()->all(),'id_fondo','nombre_fondo') ,['class'=>'form-control','prompt'=>'Seleccionar']); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
                <?= $form->field($model, 'fecha_inicio')->textInput(['readonly' => 'true','style'=>'height:1%;']); ?>
                 
                
        </div>
        <div class="col-lg-3">
                <?php
                    echo $form->field($model, 'fecha_termino')->widget(DatePicker::classname(), [
                        'value' => date('d-m-Y'),
                    'pluginOptions' => [
                    'format' => 'dd-mm-yyyy',
                     'autoclose'=>true
                     ]
                    ]);
                ?>

        </div>
        
    </div>
    <br>
    <div class="row">
        <div class="col-lg-5">

                <?= $form->field($model, 'observacion')->textArea(['style' => 'width: 400px', 'rows' => '6']) ?> 
        </div>
    </div>
<br>
<br>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Agregar convocatoria' : 'Modificar convocatoria', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Volver',

            ['index'],
            ['class'=> 'btn btn-default', 'style' => 'margin-left: 2%', 'title' => Yii::t('yii', 'Volver'), 'aria-label' => Yii::t('yii', 'Volver'), 'data-pjax' => '0',

            ] 

        );?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
