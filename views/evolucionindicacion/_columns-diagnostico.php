<?php
use yii\helpers\Url;
use yii\helpers\Html;
return [

    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label'=>'codigo',
        'value'=>'diagnostico.codigo'
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label'=>'Descripción',
        'value'=>'diagnostico.descripcion',
    ],


      [
     'class' => '\kartik\grid\BooleanColumn',
     'attribute' => 'principal',
     'trueLabel' => 'Sí',
     'falseLabel' => 'No',
      'trueIcon' => '<span class="label label-success" ">Sí</span>',
      'falseIcon' => '<span class="label label-danger" ">No</span>',
   ],

    [
         'class' => '\kartik\grid\BooleanColumn',
         'attribute' => 'diag_internacion',
         'trueLabel' => 'Sí',
         'falseLabel' => 'No',
          'trueIcon' => '<span class="label label-success" ">Sí</span>',
          'falseIcon' => '<span class="label label-danger" ">No</span>',
     ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'template' => '{delete}',
        'buttons'=>[
          'delete' => function ($url, $model, $key) {
            if( $model->diag_internacion){
              return Html::a(
                    "<button class='btn-danger btn-circle'><span class='glyphicon glyphicon-trash'></span></button>",
                  ['solicitud-diagnostico/delete', 'id' => $model->id],
                  ['data-pjax' => "0", 'role' => 'modal-remote',
                  'title' => "Eliminar",
                  'data-confirm' => '¿Estás seguro de que deseas eliminar este elemento?', // Mensaje de confirmación
                  'data-method' => 'post'] // Método HTTP para la eliminación
              );
            }else {
               return "";
            }

          },
      ],
        'urlCreator' => function($action, $model, $key, $index) {
                return Url::to([$action,'id'=>$key]);
        },
   ],


];
