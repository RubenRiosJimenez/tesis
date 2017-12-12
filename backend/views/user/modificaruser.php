<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

$this->title = 'Modificar cuenta de usuario:';
?>
<div class="user-form">
<br>
    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-12">
            <strong>Detalle de los perfiles:</strong>
            <br>
            <br>
            <strong>Administrador:</strong> Tiene permitido ingresar a <strong>todas</strong> las opciones del sistema.
            <br>
            <strong>Informático:</strong> Tiene permitido ingresar únicamente al menú de <strong>Noticias</strong>.
            <br>
            <strong>Alcalde/Secretaria:</strong> Tiene permitido ingresar únicamente al menú de <strong>Postulaciones</strong>.
            <br>
            <br>
            <br>
        </div>
    </div>

                <div class="row">
                    <div class="col-lg-4">
                        <?= $form->field($model, 'username')->textInput(['placeholder' => 'Nombre corto sin espacios']); ?>
                        <?= $form->field($model, 'email') ?>
                        <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Mínimo 6 caracteres alfanuméricos']) ?>
                        <?= $form->field($model, 'password_repeat')->passwordInput() ?>
                    </div>
                    <div class="col-lg-4">
                        <?= $form->field($model, 'name')->textInput(['placeholder' => 'Nombres y Apellidos']); ?>
                        <?= $form->field($model, 'phone')->textInput(['maxlength'=>9,'placeholder' => 'Ejemplo: Cel: 987432213 ó Fono: 422312456']); ?>
                        <?php echo $form->field($model, 'role')->dropDownList(['1' => 'Administrador', '2' => 'Informático', '3' => 'Alcalde', '4' => 'Secretaria/o'],['prompt'=>'Seleccione:']); ?>
                    </div>
                </div>
<br>
    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
        <?= Html::a('Volver',

            ['index'],
            ['class'=> 'btn btn-default', 'style' => 'margin-left: 2%', 'title' => Yii::t('yii', 'Volver'), 'aria-label' => Yii::t('yii', 'Volver'), 'data-pjax' => '0',

            ] 

        );?>        
    </div>

    <?php ActiveForm::end(); ?>

</div>
