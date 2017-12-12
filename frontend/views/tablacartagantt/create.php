<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Tablacartagantt */

$this->title = 'Agregar actividad:';
?>
<div class="tablacartagantt-create">

    <h3><?= Html::encode($this->title) ?></h3>
    <hr>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>