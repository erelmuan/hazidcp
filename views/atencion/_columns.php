<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\Servicio;
use app\models\Tipoconsulta;
use app\models\Respuesta;

use kartik\grid\GridView;

return [

    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],

      [
          'attribute' => 'id_servicio',
          'value'=> 'servicio.nombre',
          'label'=>'Servicio',

          'filter'=>ArrayHelper::map(Servicio::find()->all(), 'id','nombre'),
          'filterType' => GridView::FILTER_SELECT2,
          'filterWidgetOptions' => [
              'options' => ['prompt' => ''],
              'pluginOptions' => ['allowClear' => true],
          ],
      ],

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
         'filterInputOptions' => ['class' => 'form-control','placeholder' => 'Nombre de usuario'],
         'format' => 'raw',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fechahora',
        'value'=>function($model) {
          return date("d/m/Y H:i:s",strtotime($model->fechahora));
        },

      ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'personaasesorada',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'detalles',
    ],
    [
        'attribute' => 'id_tipoconsulta',
        'value'=> 'tipoconsulta.descripcion',
        'label'=>'Tipo de consulta',

        'filter'=>ArrayHelper::map(Tipoconsulta::find()->all(), 'id','descripcion'),
        'filterType' => GridView::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'options' => ['prompt' => ''],
            'pluginOptions' => ['allowClear' => true],
        ],
    ],

    [
        'attribute' => 'id_respuesta',
        'value'=> 'respuesta.descripcion',
        'label'=>'Respuesta',

        'filter'=>ArrayHelper::map(Respuesta::find()->all(), 'id','descripcion'),
        'filterType' => GridView::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'options' => ['prompt' => ''],
            'pluginOptions' => ['allowClear' => true],
        ],
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'paciente',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'vinculo',
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
                    $isOwner ? ['update', 'id' => $model->id] : '#',
                    [
                        'title' => $isOwner ?'Actualizar':'Solo el creador del registro puede modificarlo',
                        'aria-disabled' => $isOwner ? 'false' : 'true',
                        'tabindex' => $isOwner ? '0' : '-1',
                        'role'=>$isOwner ? 'modal-remote' : '',
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
