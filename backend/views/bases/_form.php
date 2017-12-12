<?php

use backend\models\Fondo;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use himiklab2\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model backend\models\bases */
/* @var $form yii\widgets\ActiveForm */
/* @var $model backend\models\Fondo */
?>

<div class="bases-form">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

    <div class="row">
    <div class="col-lg-3">
    <?= $form->field($model, 'nombre_base')->textInput(['maxlength' => true])?>
    </div>
    <div class="col-lg-3">
        <?= $form->field($model, 'id_fondo')->dropDownList( $var = \yii\helpers\ArrayHelper :: map(fondo :: find()->all(),'id_fondo','nombre_fondo') ,['class'=>'form-control','prompt'=>'Seleccionar']);?>
    </div>

    <div class="row" style="margin-bottom: 20px;">
        <div class="col-lg-3">
            <label class="control-label">
                Fecha Creación
            </label>
            <?= DatePicker::widget([
                'id' => '1',
                'name'=> 'bases[fecha_creacion_base]',
                'value' => date('d-m-Y'),
                'pluginOptions' => [
                    'format' => 'dd-mm-yyyy',
                    'autoclose'=>true
                ]
            ]);
            ?>
        </div>
    </div>


            <div class="col-lg-12">
                <?=
                $form->field($model, 'cuerpo_base')->widget(CKEditor::className(), ['editorOptions' => ['height' => '500px', 'width'=>'70%','toolbarSet'=>'Basic',]]);
                ?>
            </div>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Crear') : Yii::t('app', 'Actualizar'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
