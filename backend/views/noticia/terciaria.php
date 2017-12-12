<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use himiklab2\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model frontend\models\Noticia */
/* @var $form yii\widgets\ActiveForm */
$this->title = Yii::t('app', 'Modificar página de preguntas frecuentes:');

?>
<link rel="stylesheet" href="../web/css/colorbox.css" />
<script src="../web/js/jquery.js"></script>
<script src="../web/js/jquery.colorbox2.js"></script>

<div class="noticia-form">
<br>
<br>
    <?php $form = ActiveForm::begin(); ?>
    <?= 
        $form->field($model, 'noticia_terciaria')->widget(CKEditor::className(), ['editorOptions' => ['height' => '500px', 'width'=>'70%','toolbarSet'=>'Basic',]]);   
    ?>  

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary'])?>

        <a class = 'btn btn-success' id='inline7-3' href="./../../frontend/web/index.php?r=noticia%2Fprevisualizarterciaria">Previsualizar</a>


        <?= Html::a('Publicar', ['/noticia/publicarterciaria'],['style'=>'float:right; margin-right:30%', 'class' => 'btn btn-success']) ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>

        <script>
        ( function($) {
            $(document).ready( function() { 
                $("#inline7-3").colorbox({innerWidth:'90%', innerHeight:'90%'});
              } );
        } ) ( jQuery );
        </script>