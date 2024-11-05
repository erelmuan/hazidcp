<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Tipoactividad */
?>
<div class="tipoactividad-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'clasificacion',
            'descripcion',
        ],
    ]) ?>

</div>
