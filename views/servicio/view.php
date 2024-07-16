<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Servicio */
?>
<div class="servicio-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nombre',
            'codigo',
        ],
    ]) ?>

</div>
