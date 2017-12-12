<?php
/**
 * Created by PhpStorm.
 * User: Felipe
 * Date: 27-11-2017
 * Time: 20:56
 */
use yii\helpers\Html;
use yii\widgets\DetailView;

?>

<div class="row">
    <div class="col-sm-6" style="margin-right: auto;">
        <h3>
            <?= $noticia->titulo_post ?>
        </h3>
    </div>
    <div class="col-sm-6">
        <div style="float: right; line-height: 56px;">
            <?= $noticia->fecha_creacion_post ?>
        </div>
    </div>
</div>

<hr>

<div class="text-center">
<?= Html::img(Yii::getAlias('@noticiaImgUrl').'/'.$noticia->imagen_Post, ['class' => 'img', 'style'=>'width:350px; margin: 0 auto;']); ?>
</div>

<div class="text-justify">
    <p><?= $noticia->cuerpo_post ?></p>
</div>
