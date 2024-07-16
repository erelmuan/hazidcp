<?php
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\Tipodoc;

return [
      [
      'class'=>'\kartik\grid\DataColumn',
      'attribute'=>'id',
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
        'attribute' => 'tipodoc',
        'label' => 'Tipo documento',
        'value' => function($model) {
            return $model->tipodoc->documento;
        },

        'filter'=>ArrayHelper::map(Tipodoc::find()->all(), 'id','documento'),
        'filterType' => GridView::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'options' => ['prompt' => ''],
            'pluginOptions' => ['allowClear' => true],
        ],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'numdocumento',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'hc',
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'sexo',
    // ],
    [
      //nombre
      'class'=>'\kartik\grid\DataColumn',
      'attribute'=>'fechanacimiento',
      'label'=> 'Fecha de nacimiento',
      'value'=>'fechanacimiento',
      'format' => ['date', 'd/M/Y'],
      'filterInputOptions' => [
          'id' => 'fecha1',
          'class' => 'form-control',
          'autoclose'=>true,
          'format' => 'dd/mm/yyyy',
          'startView' => 'year',
          'placeholder' => 'd/m/aaaa'

      ]
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
