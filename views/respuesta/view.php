<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Respuesta */
?>
<div class="respuesta-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'descripcion',
            'detalles:ntext',
        ],
    ]) ?>

</div>
