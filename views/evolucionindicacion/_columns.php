<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\MaskedInput;

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
        'attribute'=>'observacion',
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'nombreusuario',
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fechahora',
        'value' => function ($model) {
            return date("d/m/Y H:i:s",strtotime($model->fechahora));
        },
    ],

    [
         'class'=>'\kartik\grid\DataColumn',
         'attribute'=>'tiporegistro',
         'filter' => ['indicacion' => 'Indicación', 'evolucion' => 'Evolución'],
    ],
    [
 		       'class'=>'\kartik\grid\DataColumn',
 		       'attribute'=>'especialidad',
 	  ],
    [
          'class' => 'kartik\grid\ActionColumn',
          'dropdown' => false,
          'vAlign' => 'middle',
          'urlCreator' => function($action, $model, $key, $index) {
              return Url::to([$action, 'id' => $key]);
          },
          'template' => '{view} {update} {delete}',
          'buttons' => [
            'update' => function ($url, $model, $key) {
                $isOwner = Yii::$app->user->identity->id == $model->id_usuario;
                return Html::a(
                    "<button class='btn btn-primary btn-circle " . ($isOwner ? '' : 'disabled') . "' >
                    <i class='glyphicon glyphicon-pencil' style='right: 6px; top:-1px'></i></button>",
                    $isOwner ? ['update', 'id' => $model->id, 'enfermeria' => 0] : '#',
                    [
                        'title' => $isOwner ?'Actualizar':'Solo el creador del registro puede modificarlo',
                        'aria-disabled' => $isOwner ? 'false' : 'true',
                        'tabindex' => $isOwner ? '0' : '-1',
                        'onclick' => $isOwner ? '' : 'return false;',
                    ]
                );
            },
            'delete' => function ($url, $model, $key) {
                $isOwner = Yii::$app->user->identity->id == $model->id_usuario;
                return Html::a(
                    "<button class='btn btn-danger btn-circle " . ($isOwner ? '' : 'disabled') . "'>
                    <i class='glyphicon glyphicon-trash' style='right: 6px; top: -1px;'></i></button>",
                    $isOwner ? ['delete', 'id' => $model->id] : '#',
                    [
                        'title' => $isOwner ? 'Eliminar' : 'Solo el creador del registro puede eliminarlo',
                        'data-confirm' => '¿Estás seguro de eliminar este elemento?',
                        'data-confirm'=>false,
                        'role'=>'modal-remote',
                        'data-request-method'=>'post',
                        'data-toggle'=>'tooltip',
                        'data-confirm-title'=>'Confirmar',
                        'data-confirm-message'=>'¿Esta seguro de eliminar este elemento?',
                        'data-confirm-cancel' => "Cancelar", // Texto del botón de cancelar
                        'data-confirm-ok' => "Aceptar", // Texto del botón de aceptar
                        'identifier' => 'mi_identificador',
                        'data-method' => $isOwner ? false : '',

                    ]
                );
            },
          ],
      ],

];
