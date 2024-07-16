<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;
use kartik\detail\DetailView;
use yii\widgets\MaskedInput;
use kartik\builder\Form;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EvolucionindicacionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Evoluciones';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>

<div id="w0s" class="x_panel">
  <div class="x_title"><h2><i class="fa fa-table"></i> EVOLUCIONES  </h2>
    <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Atrás', ['/solicitud'], ['class'=>'btn btn-danger grid-button']) ?></div>
  </div>
  </div>
  <?= $this->render('/solicitud/_encabezado', [
      'model_solicitud' => $model_solicitud,
  ]) ?>
<div class="x_panel">

    <ul class="nav navbar-right panel_toolbox">
        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
        </li>
    </ul>
    <legend class="text-info"><small>Ingreso internación</small>
      <? if(!isset($model_solicitud->internacion)) {
        echo Html::a('<i class="glyphicon glyphicon-log-in"></i>', ['internacion/create', 'id_solicitud'=>$model_solicitud->id],
      ['role'=>'modal-remote','title'=> 'Crear internación','class'=>'btn btn-success btn-xs']) ;
    }else {
         echo Html::a('<i class="glyphicon glyphicon-log-in"></i>', ['internacion/update', 'id'=>$model_solicitud->internacion->id,'tipo'=>'fechahoraingreso'],
        ['role'=>'modal-remote','title'=> 'Crear internación','class'=>'btn btn-success btn-xs']) ;
         echo"<small>&nbsp;Egreso internación&nbsp;</small>";
         echo Html::a('<i class="glyphicon glyphicon-log-out"></i>', ['internacion/update', 'id'=>$model_solicitud->internacion->id,'tipo'=>'fechahoraegreso'],
        ['role'=>'modal-remote','title'=> 'Actualizar internación','class'=>'btn btn-warning btn-xs']) ;
      }?>

    </legend>

    <div class="x_content" style="display: block;">
  <?
      $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL, 'formConfig'=>['labelSpan'=>4]]);

      echo Form::widget([ // fields with labels
        //  'contentBefore'=>'<legend class="text-info"><small>Datos del paciente</small></legend>',
          'model'=>$model_solicitud,
          'form'=>$form,
           'columns'=>6,
           'attributes'=>[
           'tipo_de_internacion'=>['label'=>'Tipo de internación', 'options'=>['value'=>($model_solicitud->internacion)?$model_solicitud->internacion->tipointernacion->descripcion:'(No definido)','readonly'=> true ,'url' => '#' ],'columnOptions'=>['class'=>'col-lg-2',],],
             'fecha_ingreso'=>['label'=>'Fecha/hora de ingreso', 'options'=>['value'=>($model_solicitud->internacion)?date("d/m/Y H:i:s",strtotime($model_solicitud->internacion->fechahoraingreso)):'(No definido)', 'placeholder'=>'Fecha ingreso...','readonly'=> true],'columnOptions'=>['class'=>'col-lg-3']],
             'tipo_ingreso'=>['label'=>'Tipo de ingreso', 'options'=>['value'=>($model_solicitud->internacion)?$model_solicitud->internacion->tipoingreso->descripcion:'(No definido)', 'placeholder'=>'Edad...','readonly'=> true],'columnOptions'=>['class'=>'col-sm-2']],
             'fecha_egreso'=>['label'=> 'Fecha/hora de egreso' ,'options'=>['value'=>isset($model_solicitud->internacion->fechahoraegreso)? date("d/m/Y H:i:s",strtotime($model_solicitud->internacion->fechahoraegreso)):'(No definido)', 'readonly'=> true ,'url' => '#' ],'columnOptions'=>['class'=>'col-lg-3',],],
            'tipo_egreso'=>['label'=>'Tipo de egreso', 'options'=>['value'=>isset($model_solicitud->internacion->tipoegreso)?$model_solicitud->internacion->tipoegreso->descripcion:'(No definido)', 'placeholder'=>'Edad...','readonly'=> true],'columnOptions'=>['class'=>'col-sm-2']],
           'id_solicitud'=>['type'=>Form::INPUT_HIDDEN, 'columnOptions'=>['colspan'=>0], 'options'=>['value'=>$model_solicitud->id ]],
          ]
      ]);

  ?>
  <?php ActiveForm::end(); ?>
    </div>
</div>
<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
  <?
    $class_enfermeria="";
    $class_profesional="";

    if ($tieneEspecialidadEnfermeria){
      $class_enfermeria="active";
    }else {
      $class_profesional="active";

    }
  ?>
  <li class=<?=$class_enfermeria ?>><a href="#evolucion-enfermeria" role="tab" data-toggle="tab"><b>EVOLUCIONES ENFERMERIA</b></a></li>
  <li class=<?=$class_profesional ?>><a href="#evolucion-profesional" role="tab" data-toggle="tab"><b>EVOLUCIONES-INDICACIONES</b></a></li>
  <li><a href="#diagnostico" role="tab" data-toggle="tab"><b>DIAGNOSTICOS</b></a></li>
</ul>
<!-- Nav tabs -->
<div class="tab-content">
  <div class="tab-pane <?=$class_enfermeria?> vertical-pad" id="evolucion-enfermeria">
    <div class="evolucion-index">
        <div id="ajaxCrudDatatable">
            <?=GridView::widget([
              'id'=>'crud-datatable-enfermeria',
              'dataProvider' => $modelosDat['dataProviderEnfermeria'],
              'filterModel' => $modelosDat['searchModel'],
              'pjax'=>true,
              //Para que no busque automaticamente, sino que espere a que se teclee ENTER
              'filterOnFocusOut'=>false,
              'columns' => require(__DIR__.'/_columns-enfermeria.php'),
              'toolbar'=> [
                ['content'=>
                    Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create', 'id_internacion'=>
                    ($model_solicitud->internacion)?$model_solicitud->internacion->id  :0,'enfermeria'=>1, 'id_solicitud'=>$model_solicitud->id],
                    ['title'=> 'Crear evolución enfermeria','class' => 'btn btn-success']).
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index','id_solicitud'=>$model_solicitud->id],
                    ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Refrescar'])
                ],
              ],
              'striped' => true,
              'condensed' => true,
              //Adaptacion para moviles
              'responsiveWrap' => false,
              'panel' => [
                  'type' => 'success',
                  'heading' => '<i class="glyphicon glyphicon-list"></i> Lista de evoluciones enfermeria',
                  'before'=>'<em>* Para buscar algún registro tipear en el filtro y presionar ENTER </em>',
                  '<div class="clearfix"></div>',
              ]
            ])?>
        </div>
    </div>
  </div>
  <div class="tab-pane <?=$class_profesional?> vertical-pad" id="evolucion-profesional">
    <div class="diagnostico-index">
        <div id="ajaxCrudDatatable">
            <?=GridView::widget([
              'id'=>'crud-datatable',
              'dataProvider' => $modelosDat['dataProvider'],
              'filterModel' => $modelosDat['searchModel'],
              'pjax'=>true,
              //Para que no busque automaticamente, sino que espere a que se teclee ENTER
              'filterOnFocusOut'=>false,
              'columns' => require(__DIR__.'/_columns.php'),
              'toolbar'=> [
                ['content'=>
                    Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create', 'id_internacion'=>
                    ($model_solicitud->internacion)?$model_solicitud->internacion->id  :0,'enfermeria'=>0, 'id_solicitud'=>$model_solicitud->id],
                    ['title'=> 'Crear evolución o indicación','class'=>'btn btn-primary']).
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index','id_solicitud'=>$model_solicitud->id],
                    ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Refrescar'])
                ],
              ],
              'striped' => true,
              'condensed' => true,
              //Adaptacion para moviles
              'responsiveWrap' => false,
              'panel' => [
                  'type' => 'info',
                  'heading' => '<i class="glyphicon glyphicon-list"></i> Lista de evoluciones',
                  'before'=>'<em>* Para buscar algún registro tipear en el filtro y presionar ENTER </em>',
                  '<div class="clearfix"></div>',
              ]
            ])?>
        </div>
    </div>
  </div>
  <div class="tab-pane  vertical-pad" id="diagnostico">
    <div class="diagnostico-index">
        <div id="ajaxCrudDatatable">
            <?=GridView::widget([
              'id'=>'crud-datatable-diagnostico',
              'dataProvider' => $modelosDat['dataProviderdiagnostico'],
              'filterModel' => $modelosDat['searchModelDiagnostico'],
              'pjax'=>true,
              //Para que no busque automaticamente, sino que espere a que se teclee ENTER
              'filterOnFocusOut'=>false,
              'columns' => require(__DIR__.'/_columns-diagnostico.php'),
              'toolbar'=> [
                ['content'=>
                  Html::a('<i class="glyphicon glyphicon-plus"></i>', ['/solicitud-diagnostico/create',
                   'id_solicitud'=>$model_solicitud->id,
                  'id_internacion'=>  ($model_solicitud->internacion)?$model_solicitud->internacion->id  :0  ],
                  ['title'=> 'Crear evolución o indicación','class'=>'btn btn-warning']).
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index','id_solicitud'=>$model_solicitud->id],
                    ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Refrescar'])
                ],
              ],
              'striped' => true,
              'condensed' => true,
              //Adaptacion para moviles
              'responsiveWrap' => false,
              'panel' => [
                  'type' => 'warning',
                  'heading' => '<i class="glyphicon glyphicon-list"></i> Lista de diagnosticos',
                  '<div class="clearfix"></div>',
              ]
            ])?>
        </div>
    </div>
  </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
