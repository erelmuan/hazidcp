<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Tipoingreso */
?>
<div class="tipoingreso-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'descripcion',
        ],
    ]) ?>

</div>
