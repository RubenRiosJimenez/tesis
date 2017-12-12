<?php
/**
 * Created by PhpStorm.
 * User: Rubén
 * Date: 02-12-2017
 * Time: 20:12
 */


use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\helpers\HtmlPurifier;
?>
<div class="bases">

    <div class="item  col-xs-4 col-lg-4">
        <div class="thumbnail">

            <!--img class="group list-group-image" src="http://placehold.it/400x250/000/fff" alt="" /-->
            <div class="caption">
                <h4 class="group inner list-group-item-heading">
                    <?= Html::encode($model->nombre_base) ?></h4>
                <div class="row">
                    <div class="col-lg-12 col-md-6">
                        <p class="lead">
                            <?= HtmlPurifier::process($model->getSubString($model->cuerpo_base, 20)) ?></p>

                    </div>
                    <div class="col-lg-12 col-md-6" style="text-align: right;">
                        <a class="btn btn-success" href="<?php echo Url::toRoute(['bases/detalle', 'id' => $model->id_base]); ?>">Ver</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>