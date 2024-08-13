<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Diagnostico */
?>
<div class="diagnostico-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'descripcion',
            'codigo',
        ],
    ]) ?>

</div>
