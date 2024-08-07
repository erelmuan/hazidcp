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
        'attribute'=>'tipodoc',
        'value'=>'tipodoc.documento',
        'label'=> 'Tipo doc.',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'numdocumento',
    ],


];
