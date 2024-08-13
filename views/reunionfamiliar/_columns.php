<?php
use yii\helpers\Url;

return [

    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
        // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'lugar',
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fechahora',
        'value' => function($model){
          return date("d/m/Y H:i:s",strtotime($model->fechahora));
        } ,
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'familiares',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'profesionales',
    ],

    [
       'class' => '\kartik\grid\BooleanColumn',
       'attribute' => 'aceptanacompañamiento',
       'trueLabel' => 'Sí',
       'falseLabel' => 'No',
        'trueIcon' => '<span class="label label-success" ">Sí</span>',
        'falseIcon' => '<span class="label label-danger" ">No</span>',
        'filterInputOptions' => [
          'class' => 'form-control',
           'prompt' => 'Seleccionar'
        ],
     ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'detallesreunion',
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id_solicitud',
    // ],

    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) {
                return Url::to([$action,'id'=>$key]);
        },
    ],

];
