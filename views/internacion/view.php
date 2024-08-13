<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Internacion */
?>
<div class="internacion-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_tipointernacion',
            'fechahoraingreso',
            'id_tipoingreso',
            'fechahoraegreso',
            'id_tipoegreso',
            'id_solicitud',
        ],
    ]) ?>

</div>
