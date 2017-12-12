<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

$this->title = 'Registrarse';
?>

<script src="../web/js/jquery.rut.js"></script>

<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>
    <hr>

    <p>Para registrarse, por favor ingresa la siguiente información:</p>


            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                <div class="row">
                    <div class="col-lg-5">
                        <?= $form->field($model, 'username')->textInput(['style'=>'height:1%;','placeholder' => 'Nombre corto sin espacios']); ?>
                        <?= $form->field($model, 'email') ?>
                        <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Mínimo 6 caracteres alfanuméricos']) ?>
                        <?= $form->field($model, 'password_repeat')->passwordInput() ?>
                    </div>
                    <div class="col-lg-5">
                        <?= $form->field($concursante, 'nombreConcursante')->textInput(['style'=>'height:1%;','placeholder' => 'Nombres y Apellidos']); ?>
                        <?= $form->field($concursante, 'rut')->textInput(['id' => 'rut','style'=>'height:1%;']); ?>
                        <?= $form->field($concursante, 'domicilio') ?>
                        <?= $form->field($concursante, 'telefono')->textInput(['style'=>'height:1%;','maxlength'=>9,'placeholder' => 'Ejemplo: Cel: 987432213 ó Fono: 422312456']); ?>
                        <?= $form->field($concursante, 'id_tipoConcursante')->dropDownList($items,['prompt'=>'Seleccione','style' => 'width:90%;']) ?>
                    </div>
                </div>
                <div class="form-group">
                    <?= Html::submitButton('Registrar', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
</div>
<script type="text/javascript">
    
$("input#rut").rut({
    formatOn: 'keyup'
});

</script>