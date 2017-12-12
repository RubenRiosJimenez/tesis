<?php
/**
 * Created by PhpStorm.
 * User: Rubén
 * Date: 02-12-2017
 * Time: 19:41
 */

use yii\helpers\Html;
use yii\widgets\DetailView;

?>

<div class="row">
    <div class="col-sm-6" style="margin-right: auto;">
        <h3>

            <?= $bases->nombre_base ?>
        </h3>
    </div>
    <div class="col-sm-6">
        <div style="float: right; line-height: 56px;">
            <?= $bases->fecha_creacion_base ?>

        </div>
    </div>
</div>

<hr>



<div class="text-justify">
    <p><?= $bases->cuerpo_base ?></p>
</div>