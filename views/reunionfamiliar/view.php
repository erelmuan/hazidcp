<?php

// use yii\widgets\DetailView;
use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Reunionfamiliar */
?>
<div class="reunionfamiliar-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'lugar',
            ['value'=> date("d/m/Y H:i:s",strtotime($model->fechahora)),
              'label'=> 'Fecha y hora',
           ],
            'familiares:ntext',
            'profesionales:ntext',
            'aceptanacompañamiento:boolean',
            'detallesreunion:ntext',

        ],
    ]) ?>

</div>
