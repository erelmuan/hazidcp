<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Plantillareunionfamiliar */
?>
<div class="plantillareunionfamiliar-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'codigo',
            'descripcion:ntext',
        ],
    ]) ?>

</div>
