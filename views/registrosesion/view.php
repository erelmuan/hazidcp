<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Registrosesion */
?>
<div class="registrosesion-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_usuario',
            'iniciosesion',
            'ip',
            'informacionusuario',
            'cookie',
            'cierresesion',
        ],
    ]) ?>

</div>
