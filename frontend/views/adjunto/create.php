<?php

use yii\helpers\Html;
use frontend\models\Tipoarchivo;


/* @var $this yii\web\View */
/* @var $model frontend\models\Adjunto */

$this->title = 'Agregar documento:';
?>

<?php

 $request = Yii::$app->request;
 $id_tipoArchivo = $request->get('id_tipoArchivo');
?>

<div class="adjunto-create">

    <h3><?= Html::encode($this->title) ?></h3>
    <hr>
        <div  class="row">
    <div class="col-lg-12">
    <?php
        $buscaTipoArchivo = Tipoarchivo::find()->where(['id_tipoArchivo' => $id_tipoArchivo])->one();
        echo $buscaTipoArchivo->nombre_tipoArchivo; 
     ?>    
    </div>
</div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
