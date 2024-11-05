<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Actividad */
?>
<div class="actividad-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
              'value'=>date("d/m/Y H:i:s",strtotime($model->fechahora)),
              'label'=> 'Fecha y hora',
            ],
            'clasificacion',
            ['class'=>'\kartik\grid\DataColumn',
            'label'=>'Tipo de actividad',
            'value' => $model->tipoactividad ? $model->tipoactividad->descripcion : 'No definido',
            ],
            'paciente',
            'observacion:ntext',
            [
                'class'=>'\kartik\grid\DataColumn',
                'attribute'=>'usuario',
                'width' => '170px',
                'value' => function($model) {
                  return Html::a( $model->usuario->usuario, ['usuario/view',"id"=> $model->usuario->id]
                    ,[    'class' => 'text-success','role'=>'modal-remote','title'=>'Datos del usuario','data-toggle'=>'tooltip']
                   );
                 }
                 ,
                 'filterInputOptions' => ['placeholder' => 'Ingrese Dni,HC o nombre'],
                 'format' => 'raw',
            ],
        ],
    ]) ?>

</div>
