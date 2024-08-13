<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Empresa */
?>
<div class="empresa-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'denominacion',
        ],
    ]) ?>

</div>
