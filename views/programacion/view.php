<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Programacion */
?>
<div class="programacion-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_solicitud',
            'id_usuario',
            'fecha',
            'turno',
            'practica',
        ],
    ]) ?>

</div>
