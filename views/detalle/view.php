<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Detalle */
?>
<div class="detalle-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'descripcion',
            [
              'value'=>$model->tipoegreso->descripcion,
              'label'=>'Tipo de egreso',
            ],
          ],
    ]) ?>

</div>
