<?php
use yii\helpers\Url;

return [
    [
        'class' => '\kartik\grid\RadioColumn',
        'width' => '20px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id',
        'hidden' => true
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'nombre',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'apellido',
    ],
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


];
