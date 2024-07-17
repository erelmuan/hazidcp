<?php
use yii\helpers\Url;

return [

    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
        [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'apellido',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'nombre',
    ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'tipodoc',
    //     'value'=>'tipodoc.documento',
    //     'label'=> 'Tipo doc.',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'numdocumento',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'matricula',
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'especialidad',
        'value'=>'especialidad.nombre',
        'label'=>'Especialidad',

    ],

    [
       'class' => '\kartik\grid\BooleanColumn',
       'attribute' => 'visualizar',
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
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) {
                return Url::to([$action,'id'=>$key]);
        },
        'updateOptions'=>['title'=>'Actualizar',
         'data-toggle'=>'tooltip',
         'icon'=>"<button class='btn-primary btn-circle'>
         <span class='glyphicon glyphicon-pencil'></span></button>"],


    ],

];
