<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Reunionfamiliar */
?>
<div class="reunionfamiliar-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'lugar',
            'familiares:ntext',
            'profesionales:ntext',
            'aceptanacompañamiento:boolean',
            'detallesreunion:ntext',
            ['value'=> date("d/m/Y H:i:s",strtotime($model->fechahora)),
              'label'=> 'Fecha y hora',
           ],
        ],
    ]) ?>

</div>
