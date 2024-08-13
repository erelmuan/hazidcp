<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Codigo */
?>
<div class="codigo-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'valor',
            'descripcion',
            'activo:boolean',
        ],
    ]) ?>

</div>
