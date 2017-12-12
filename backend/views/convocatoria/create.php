<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Convocatoria */

$this->title = 'Agregar convocatoria';
?>
<div class="convocatoria-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>


</div>
