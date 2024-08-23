<?php
use yii\helpers\Url;

return [

    [
      'class'=>'\kartik\grid\DataColumn',
       'attribute' => 'fechasolicitud',
       'format' => ['date', 'd/M/Y'],
   ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label'=>'Paciente',
        'value' => function($model) {
          return $model->paciente->apellido .', '.$model->paciente->nombre;
         }
         ,
    ],


    [
        'class'=>'\kartik\grid\DataColumn',
        'label'=>'Procedencia',
        'attribute'=>'procedencia',
        'value'=>'procedencia.nombre',

    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'value' => function($model) {
          return $model->profesional->apellido .', '.$model->profesional->nombre;
        },
         'label'=>'Profesional solicitante',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'value' => function($model) {
          return $model->profesionalAcargo->apellido .', '.$model->profesionalAcargo->nombre;
        },
         'label'=>'Profesional a cargo',
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'observacion',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute' => 'estado',
        'label' => 'Estado',
        'value' => 'estado.descripcion',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'edad',
        'value'=>function($model) {
          return $model->calcular_edad(); },
        'label'=> 'Edad al momento de la solicitud',

    ],
    [
       'class'=>'\kartik\grid\DataColumn',
       'attribute'=>'direccion',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'barrio',
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
