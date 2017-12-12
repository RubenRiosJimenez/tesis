<?php

use app\models\Estadofondo;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Fondo;


/* @var $this yii\web\View */
/* @var $model backend\models\Fondo */
/* @var $model app\models\Estadofondo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fondo-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-3">
            <?= $form->field($model, 'nombre_fondo')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'nombre_estado')->dropDownList( $var = \yii\helpers\ArrayHelper :: map(Estadofondo :: find()->all(),'nombre_estado','nombre_estado') ,['class'=>'form-control','prompt'=>'Seleccionar']); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'observacion_fondo')->textarea(['rows' => 6]) ?>
        </div>
    </div>

    <div class="row" style="margin-bottom: 20px;">
        <div class="col-lg-3">
            <label class="control-label">
                Fecha Creación
            </label>
            <?= DatePicker::widget([
                'id' => '1',
                'name'=> 'Fondo[fecha_creacion]',
                'value' => date('d-m-Y'),
                'pluginOptions' => [
                    'format' => 'dd-mm-yyyy',
                    'autoclose'=>true
                ]
            ]);
            ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Crear') : Yii::t('app', 'Modificar'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
