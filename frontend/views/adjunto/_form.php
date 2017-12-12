<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
$request = Yii::$app->request;
$id_formulario = $request->get('id_formulario');
$id_postulacion = $request->get('id_postulacion');
/* @var $this yii\web\View */
/* @var $model frontend\models\Adjunto */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="adjunto-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'data-pjax' => true],]); ?>
    <div class="row">
        <div class="col-lg-8">
            <?php echo $form -> field($model,'archivo[]')->widget(FileInput::classname(),['id'=>'file',
                'pluginOptions' => [
        'maxFileSize'=>10000,
        'maxFileCount' => 10,
        'previewFileType' => 'any',
        'allowedFileExtensions'=>['doc','ppt','xls','docx','pptx','xlsx','pdf','jpg','gif','png','bmp','jpeg','jpe']
    ],

            'options' => ['accept' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation, application/vnd.ms-powerpoint, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet ,application/vnd.ms-excel, application/pdf, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document, image/*','multiple' => true],
            'language' => 'es', 
            ])
         ?>
            <?= $form->field($model, 'id_formulario')->hiddenInput(['value'=> $id_formulario])->label(false);?>

        </div>
    </div>
<br>
<br>
<br>
    <?php ActiveForm::end(); ?>
</div>

