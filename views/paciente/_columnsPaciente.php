<?php
use yii\helpers\Url;
use yii\helpers\Html;

return [


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
        'attribute'=>'sexo',
    ],
    [
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
        'label' => 'Domicilios',
          'format'    => 'html',
          'value'     => function($model)
          {
              $items = "";
              $num=1;
              foreach ($model->domicilios as $domicilio) {
                  $items .="<u><b>DOMICILIO</b> </u> ".$num."<br>";
                  $items .="<b>Dirección:</b>". $domicilio->direccion."<br>
                          <b>Tipo</b>: ".$domicilio->tipodom->descripcion."<br>
                          <b>Provincia</b>: ".$domicilio->provincia->nombre."<br>
                          <b>Localidad</b>: ".$domicilio->localidad->nombre."<br>
                          <b>Barrio</b>: ".($domicilio->barrio==null?'No definido':$domicilio->barrio->nombre)."<br>
                          <b>Principal</b>: ".($domicilio->principal?"SI":"NO")."<br>";

                    $num ++;

              }
              return $items;
          },
    ],
    [
      'class' => 'kartik\grid\ActionColumn',

      'dropdown' => false,
      'vAlign'=>'middle',
      'urlCreator' => function($action, $model, $key, $index) {
              return Url::to([$action,'id'=>$key]);
      },
      'template'=> '{agregar}{update}',
      'buttons'=> [
             'agregar' => function ($url, $model, $key) {
               return Html::a(
                 "<button class='btn-success btn-circle'>  <span class='glyphicon glyphicon-copy'></span></button>",
                ['/solicitud/create', 'id_paciente' => $model->id],
                [
                'data-toggle'=>'tooltip',
                'title'=>"Se añadira el paciente a la solicitud"]) ;
               },
            ],

      'updateOptions'=>['title'=>'Actualizar', 'data-toggle'=>'tooltip','icon'=>"<button class='btn-primary btn-circle'><span class='glyphicon glyphicon-pencil'></span></button>"],

   ],



];
