<?php
use yii\helpers\Url;
use yii\helpers\Html;

return [

        [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'usuario',
        'width' => '170px',
        'value' => function($model) {
          return Html::a( $model->usuario->usuario, ['usuario/view',"id"=> $model->usuario->id]

            ,[    'class' => 'text-success','role'=>'modal-remote','title'=>'Datos del paciente','data-toggle'=>'tooltip']
           );

         }
         ,

         'filterInputOptions' => ['placeholder' => 'Ingrese Dni,HC o nombre'],
         'format' => 'raw',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'accion',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'tabla',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fecha',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'hora',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ip',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'informacionusuario',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'cambios',
         'format' => 'raw',
    ],
    [
    'class'=>'\kartik\grid\DataColumn',
    'attribute'=>'registro',
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'template' => '{view}',

        'urlCreator' => function($action, $model, $key, $index) {
                return Url::to([$action,'id'=>$key]);
        },

    ],

];
