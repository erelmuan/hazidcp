<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Prestador */
?>
<div class="prestador-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nombre',
            'apellido',
            'tipodoc.documento',
            'numdocumento',
        ],
    ]) ?>

</div>
