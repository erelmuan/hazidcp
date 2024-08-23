<?php

//use yii\widgets\DetailView;
use yii\helpers\Html;
use common\components\Modal;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Solicitud */
?>

<div class="solicitud-formativa-view">

    <?= DetailView::widget([
        'model' => $model,
        'condensed'=>true,
        'hover'=>true,
        'mode'=>DetailView::MODE_VIEW,
        'panel'=>[
            'heading'=>'SERVICIO: ' . $model->servicio->nombre,
            'type'=>DetailView::TYPE_PRIMARY,
            'headingOptions'=>[
              'template' => '{buttons2}',
            ]
        ],
        'buttons1' => Html::a('<i class="glyphicon glyphicon-print"></i>', ['ruta/al/controlador', 'id' => $model->id], [
            'class' => 'btn btn-default',
            'title' => 'Imprimir',
            'target' => '_blank',
            'data-pjax' => '0'
        ]),
        'buttons2' => '',


        'attributes' => [
          [
            'class'=>'\kartik\grid\DataColumn',
            'label'=>'Paciente',
            'value' => $model->paciente->apellido .', '.$model->paciente->nombre,
          ],
          [
            'class'=>'\kartik\grid\DataColumn',
            'label'=>'Tipo y n° de documento',
            'value' => $model->paciente->tipodoc->documento .': '.$model->paciente->numdocumento,
          ],
          [
            'class'=>'\kartik\grid\DataColumn',
            'label'=>'Historia clinica',
            'value' => $model->paciente->hc,
          ],
          [
            'class'=>'\kartik\grid\DataColumn',
            'attribute' => 'fechasolicitud',
            'format' => ['date', 'd/M/Y'],
         ],
          [
              'label' => 'Domicilio',
                'format'    => 'html',
                'value'     => call_user_func(function($model)
                {
                    $items = "";
                    $num=1;
                    foreach ($model->paciente->domicilios as $domicilio) {
                        $items .="<u><b>DOMICILIO</b> </u> ".$num."<br>";
                        $items .="<b>Dirección: </b>". $domicilio->direccion."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Tipo</b>:".$domicilio->tipodom->descripcion
                               ."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Provincia</b>: ".$domicilio->provincia->nombre."<br>
                                <b>Localidad</b>: ".$domicilio->localidad->nombre
                                ."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Barrio</b>: ".($domicilio->barrio==null?'No definido':$domicilio->barrio->nombre)
                                ."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Principal</b>: ".($domicilio->principal?"SI":"NO")."<br>";
                          $num ++;
                    }
                    return $items;
                }, $model)
          ],
          [
          'value'=> $model->procedencia->nombre ,
          'label'=> 'Procedencia',
          ],
          [
              'class'=>'\kartik\grid\DataColumn',
              'label'=>'Profesional solicitante',
              'value' =>  $model->profesional->apellido .', '.$model->profesional->nombre,
          ],
          [
              'class'=>'\kartik\grid\DataColumn',
              'label'=>'Profesional a cargo',
              'value' =>  $model->profesionalAcargo->apellido .', '.$model->profesionalAcargo->nombre,
          ],
          [
              'class'=>'\kartik\grid\DataColumn',
              'attribute'=>'observacion',
          ],
          [
              'class'=>'\kartik\grid\DataColumn',
              'attribute' => 'servicio',
              'label' => 'Servicio',
              'value' => $model->servicio->nombre,
          ],
          [
              'class'=>'\kartik\grid\DataColumn',
              'attribute' => 'estado',
              'label' => 'Estado',
              'value' => $model->estado->descripcion,
          ],
          [
              'class'=>'\kartik\grid\DataColumn',
              'attribute'=>'edad',
              'value'=>$model->calcular_edad(),
              'label'=> 'Edad al momento de la solicitud',

          ],
          [
              'label' => 'Diagnosticos',
                'format'    => 'html',
                'value'     => call_user_func(function($model)
                {
                    $items = "";
                    $num=1;
                    foreach ($model->solicitudDiagnosticos as $soldiagnostico) {
                        $items .="<b>Descripcion:</b> ". $soldiagnostico->diagnostico->descripcion."<br>
                                <b>codigo</b>: ".$soldiagnostico->diagnostico->codigo."&nbsp;&nbsp;
                                <b>Principal</b>: ".($soldiagnostico->principal?"SI":"NO")."<br>";
                          $num ++;

                    }
                    return $items;
                }, $model)
          ],
          [
              'label' => 'Diagnosticos de la int.',
                'format'    => 'html',
                'value'     => call_user_func(function($model)
                {
                    $items = "";
                    $num=1;
                    foreach ($model->solicitudDiagnosticoInternaciones as $soldiagnosticoInt) {
                        $items .="<b>Descripcion:</b> ". $soldiagnosticoInt->diagnostico->descripcion."<br>
                                <b>codigo</b>: ".$soldiagnosticoInt->diagnostico->codigo."&nbsp;&nbsp;
                                <b>Principal</b>: ".($soldiagnosticoInt->principal?"SI":"NO")."<br>";
                          $num ++;
                        }
                    return $items;
                }, $model)
          ],
          [
                'label' => 'Obra social',
                'format'    => 'html',
                'value'     => call_user_func(function($model)
                {
                    $items = "";
                    $num=1;
                    foreach ($model->paciente->pacienteObrasocials as $carnet) {
                        $items .="<u><b>OBRA SOCIAL</b> </u> ".$num."<br>";
                        $items .= "<b>Denominación:</b> ".$carnet->obrasocial->denominacion."<br>
                        <b>Nº Afiliado:</b> ". $carnet->nroafiliado."<br>";
                        $num ++;

                    }
                    return $items;
                }, $model)
         ],
        ],
    ]) ?>

</div>
<? if (isset($model->internacion)){
  $internacion=$model->internacion; ?>
<?= DetailView::widget([
    'model' => $internacion,
    'condensed'=>true,
    'hover'=>true,
    'mode' => 'view',
    'buttons1' => false, // Eliminar los botones de edición
    'buttons2' => false, // Eliminar los botones de eliminación
    'panel'=>[
        'heading'=>'INTERNACIÓN',
        'type'=>DetailView::TYPE_SUCCESS,

    ],

    'attributes' => [

      [


      'columns' => [

             [
               'value' => ($internacion->tipoingreso)?$internacion->tipoingreso->descripcion:'(no definido)',
               'label' => 'Tipo de INGRESO',
              ],
              [
                'value' => ($internacion->tipoegreso)?$internacion->tipoegreso->descripcion:'(no definido)',
                'label' => 'Tipo de EGRESO',
               ],
              [
               'value' => ($internacion->detalle)?$internacion->detalle->descripcion:'(no definido)',
               'label' => 'Detalle',
              ],
         ],
      ],

      [
      'columns' => [
            [
              'value' => ($internacion->tipointernacion)?$internacion->tipointernacion->descripcion:'No definido',
              'label'=> 'Tipo internacion',
            ],
            [
              'value' => ($internacion->fechahoraingreso)?date("d/m/Y H:i:s",strtotime($internacion->fechahoraingreso)):'(no definido)',
                'label'=> 'Fecha y hora de INGRESO',
             ],
             [
                 'value' => ($internacion->fechahoraegreso)?date("d/m/Y H:i:s",strtotime($internacion->fechahoraegreso)):'(no definido)',
                 'label'=> 'Fecha y hora de EGRESO',
              ],

            ],

      ],
    ],
]);

  } ?>
<? if (isset($model->reunionfamiliars)){
    $cant_reunion=0;
  foreach ($model->reunionfamiliars as $reunionfamiliar) {
    $cant_reunion ++;
?>
<div class="reunionfamiliar-view">

    <?= DetailView::widget([
        'model' => $reunionfamiliar,
        'condensed'=>true,
        'hover'=>true,
        'mode' => 'view',
        'buttons1' => false, // Eliminar los botones de edición
        'buttons2' => false, // Eliminar los botones de eliminación
        'panel'=>[
            'heading'=>'REUNION FAMILIAR: # ' . $cant_reunion,
            'type'=>DetailView::TYPE_INFO,

        ],
        'attributes' => [
          [
            'value'=> $reunionfamiliar->familiares ,
            'label'=> 'Familiares',
          ],
          [
              'class' => '\kartik\grid\BooleanColumn',
              'value' => $reunionfamiliar->aceptanacompañamiento ? 'Sí' : 'No',
              'label' => 'Aceptan acompañamiento?',
          ],
          [
              'value'=> date("d/m/Y H:i:s",strtotime($reunionfamiliar->fechahora)) ,
              'label'=> 'Fecha y hora de reunion',
           ],

           [
           'value'=> $reunionfamiliar->profesionales,
           'label'=> 'Profesionales',
            ],
            [
            'value'=> $reunionfamiliar->detallesreunion,
            'label'=> 'Detalles de la reunión',
           ],
          ],
    ]);


    ?>


</div>
<?   }  } ?>
