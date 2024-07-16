eli<?php

use yii\widgets\DetailView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Atencion */
?>
<div class="atencion-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
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
            [
              'value'=>date("d/m/Y H:i:s",strtotime($model->fechahora)),
              'label'=> 'Fecha y hora',
           ],
            'personaasesorada',
            'detalles:ntext',

            ['class'=>'\kartik\grid\DataColumn',
            'label'=>'Tipo de consulta',
            'value' => $model->tipoconsulta ? $model->tipoconsulta->descripcion : 'No definido',

            ],
            ['class'=>'\kartik\grid\DataColumn',
              'label'=>'Respuesta',
              'value' => $model->respuesta ? $model->respuesta->descripcion : 'No definido',
            ],
            'paciente',
            'vinculo',
            ['class'=>'\kartik\grid\DataColumn',
            'label'=>'Servicio',
            'value'=>$model->servicio->nombre

           ],
        ],
    ]) ?>

</div>
