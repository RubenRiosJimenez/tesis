<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Tablacartagantt */

$this->title = 'Modificar tarea:';
?>
<div class="tablacartagantt-update">

    <h3><?= Html::encode($this->title) ?></h3>
    <br>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

