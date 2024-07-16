<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Especialidad */
?>
<div class="especialidad-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nombre',
        ],
    ]) ?>

</div>
