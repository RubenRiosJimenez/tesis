<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use backend\models\Fondo;
use backend\controllers\ConvocatoriaController;
use backend\models\Estadopostulacion;
use kartik\daterange\DateRangePicker;
/* @var $this yii\web\View */
/* @var $model backend\models\Convocatoria */
/* @var $form yii\widgets\ActiveForm */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $items backend\controllers\ConvocatoriaController */

?>

<div class="convocatoria-form">

    <?php $form = ActiveForm::begin(['id' => 'convocatoria-form', 'options' => ['data-pjax' => true]]); ?>


    <div class="row">

        <div class="col-lg-3">
            <?= $form->field($model, 'nombreConvocatoria')->textInput(['maxlength' => true]) ?>

        </div>
           <div class="col-lg-3 ">
        <?= $form->field($model, 'montoConvocatoria')->textInput(['maxlength'=>9]) ?>
        </div>

        <div class="col-lg-3">

            <?php echo $form->field($model, 'id_fondo')->dropDownList( $var = \yii\helpers\ArrayHelper :: map(fondo :: find()->all(),'id_fondo','nombre_fondo') ,['class'=>'form-control','prompt'=>'Seleccionar']); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3">

                <?php   
                    echo $form->field($model, 'fecha_inicio')->widget(DatePicker::classname(), [
                    'pluginOptions' => [
                    'format' => 'dd-mm-yyyy',
                     'autoclose'=>true
                     ]
                    ]);                 
                ?>
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
