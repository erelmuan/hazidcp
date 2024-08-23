<?
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
// use kartik\widgets\ActiveForm;
// use yii\widgets\ActiveForm;
use nex\chosen\Chosen;
use yii\helpers\ArrayHelper;
use app\models\Procedencia;
use app\models\SolicitudDiagnostico;
use kartik\datecontrol\DateControl;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;
use yii\widgets\Pjax;
use kartik\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $searchModel app\models\SolicitudSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Solicitudes';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>

<div id="w0s" class="x_panel">
  <div class="x_title">
    <h2> <?=$model->isNewRecord ? "<i class='glyphicon glyphicon-plus'></i> NUEVA SOLICITUD" : "<i class='glyphicon glyphicon-pencil'></i> ACTUALIZAR SOLICITUD" ; ?>
    </h2>
    <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?echo Html::button('<i class="glyphicon glyphicon-arrow-left"></i> Atrás',array('name' => 'btnBack','onclick'=>'js:history.go(-1);returnFalse;','id'=>'botonAtras')); ?></div>
</div>
  </div>
</br>
    <div class='row'>
    <div class="x_panel" >
      <legend class="text-info"><small>CABECERA DE LA SOLICITUD</small></legend>
    <div class='row'>
    <div class='col-sm-3'>
    <label>Profesional solicitante:<span id='profesional'> </span>
      <button onclick="quitarSeleccion() " title="Busqueda avanzada de profesional" type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target=".bs-profesional-modal-lg" style="margin-left: 10px;"><i class="glyphicon glyphicon-search" ></i></button>
    </label>
    <label>Profesional a cargo:<span id='profesional'> </span>
      <button onclick="quitarSeleccion() " title="Busqueda avanzada de profesional" type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target=".bs-profesionalAC-modal-lg" style="margin-left: 10px;"><i class="glyphicon glyphicon-search" ></i></button>
    </label>
    </div>
    <?php $form = ActiveForm::begin();
      // $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL, 'formConfig'=>['labelSpan'=>4]]);
      $mapprocedencia = ArrayHelper::map(Procedencia::find()->all() , 'id',  'nombre'  );
    ?>

      <div class='col-sm-3'>
        <label> Paciente </label></br>
        <input id="solicitud-paciente" class="form-control"  style="width:250px;" value='<?=$model_paciente->apellido.", ".$model_paciente->nombre; ?>' type="text" readonly>
        <?=$form->field($model, 'id_paciente')->hiddenInput(['value'=>$model_paciente->id])->label(false); ?>
        <label class="text-primary"> Profesional solictiante</label> </br>
        <input id="solicitud-profesional" class="form-control" style="width:250px;" value='<?=($model->profesional)?$model->profesional->apellido.", ".$model->profesional->nombre:'' ?>' type="text" readonly>
        <?=$form->field($model, 'id_profesional')->hiddenInput()->label(false); ?>
        <?=$form->field($model, 'barrio')->hiddenInput(['value'=>$model_paciente->barrioPrincipal()])->label(false); ?>

<?
      echo $form->field($model, 'id_procedencia')->widget(
        Chosen::className(), [
         'items' => $mapprocedencia,
          'placeholder' => 'Selecciona una opción',
         'clientOptions' => [
           'language' => 'es',
           'rtl'=> true,
             'search_contains' => true,
             'single_backstroke_delete' => false,
         ],])->label("Procedencia");
?>
          </div>
          <div class='col-sm-3'>
              <?=$form->field($model, 'id_servicio')->dropDownList($model->servicios())->label('Servicio') ;?>
              <label class="text-success"> Profesional a cargo</label>
              <input id="solicitud-profesional-acargo" class="form-control" style="width:250px;" value='<?=($model->profesionalAcargo)?$model->profesionalAcargo->apellido.", ".$model->profesionalAcargo->nombre:'' ?>' type="text" readonly>
              <?=$form->field($model, 'id_profesional_acargo')->hiddenInput()->label(false); ?>
              <?=$form->field($model, 'direccion')->hiddenInput(['value'=>$model_paciente->direccionPrincipal()])->label(false); ?>
              <?=$form->field($model, 'id_estado')->dropDownList($model->estados())->label('Estado') ;?>
         </div>
         <div class='col-sm-3'>
            <? echo $form->field($model, 'fechasolicitud')->widget(DateControl::classname(), [

                'type'=>DateControl::FORMAT_DATE,
                'autoWidget'=>true,
                'displayFormat' => 'php:d/m/Y',
                'saveFormat' => 'php:Y-m-d',
                'options' => [
                    'pluginOptions' => [
                        'autoclose' => true,
                    ],
                ],

              ])->label('Fecha de solicitud');
            ?>

            <?=$form->field($model, "observacion")->textarea(["rows" => 5]) ; ?>

          </div>
          <!--Inicio sección de solucion-diagnosticos -->

            <?php
                   //Cargar un sol_diagnostico por defecto
                    $sol_diagnostico = new SolicitudDiagnostico();
                    $sol_diagnostico->loadDefaultValues();

           ?>
                    <div id="solicitud-sol_diagnostico">
                      <div class="row" style="margin-bottom:16px;">
                        <div class="col-lg-12">
                         <?php
                         //Boton para insertar nuevo formulario de sol_diagnostico
                         echo Html::a('<i class="glyphicon glyphicon-plus" ></i>', 'javascript:void(0);', [
                            'id' => 'solicitud-nuevo-sol_diagnostico-boton',
                            'class' => 'btn btn-primary btn-md'
                          ])
                          ?>
                          <b>DIAGNÓSTICO</b>
                          </button>
                     </div>
                      </div>
                     <!-- Cabeceras con etiquetas -->
                     <div class="row">
                       <div class="col-lg-5">
                         <label class="control-label">
                           Descripción
                         </label>
                       </div>
                       <div class="col-lg-2">
                         <label class="control-label">
                         código
                         </label>
                       </div>
                       <div class="col-lg-1">
                         <label class="control-label">
                         Principal
                         </label>
                       </div>
                       <div class="col-lg-1">
                         <label class="control-label">
                         Buscar diagnostico
                         </label>
                       </div>
                       <div class="col-lg-1">
                         <label class="control-label">
                         Eliminar
                        </label>
                       </div>
                     </div>
                   </div>

                   <?php

                    //Recorrer los sol_diagnostico
                     foreach ($model->solicitudDiagnosticos as $key => $_sol_diagnostico) {
                       //Para cada sol_diagnostico renderizar el formulario de sol_diagnostico
                       //Si el sol_diagnostico está vacío colocar 'nuevo' como clave, si no asignar el id del diagnostico
                       echo '<tr>';
                       echo $this->render('_form-sol_diagnostico', [
                         'key' => $_sol_diagnostico->isNewRecord ? (strpos($key, 'nuevo') !== false ? $key : 'nuevo' . $key) : $_sol_diagnostico->id,
                         'form' => $form,
                         'sol_diagnostico' => $_sol_diagnostico,
                         'model' => $model,
                       ]);
                       echo '</tr>';
                     }
                   //sol_diagnostico vacío con su respectivo formulario que se utilizará para copiar cada vez que se presione el botón de nuevo sol_diagnostico
                     $sol_diagnostico = new SolicitudDiagnostico();
                     echo '<div id="solicitud-nuevo-sol_diagnostico-block" style="display:none">';
                     echo $this->render('_form-sol_diagnostico', [
                           'key' => '__id__',
                           'form' => $form,
                           'sol_diagnostico' => $sol_diagnostico,
                           'model' => $model,

                       ]);
                       echo '</div>';
                     ?>



         </div>




<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>

<script>

var input = document.getElementById("profesionalbuscar");
input.addEventListener("keyup", function(event) {
  if (event.keyCode === 13) {
   event.preventDefault();
   document.getElementById("button_profesional").click();
  }
});
function quitarSeleccion (){
  $('span.kv-clear-radio').click();

}
function profesionalba(){

  $.ajax({
        url: '<?php echo Yii::$app->request->baseUrl. '/profesional/search' ?>',
        type: 'get',
        data: {
              "ProfesionalSearch[matricula]":$("#profesionalbuscar").val() ,
              _csrf : '<?=Yii::$app->request->getCsrfToken()?>'
              },
        success: function (data) {
          var content = JSON.parse(data);
          if (content.status=='error'){
            swal(
            content.mensaje ,
            'PRESIONAR OK',
            'error'
            )
          }else{
            swal({
           title: "Confirmado!",
           text: "Se agrego el profesional",
           type: "success",
           timer: 800
         });
          document.getElementById("solicitud-profesional").value= content['apellido']+" "+content['nombre'];
          document.getElementById("solicitud-id_profesional").value= content['id'];
        }
        }
   });

}
///script agregar y quitar profesional desde la busqueda avanzada


function agregarFormularioMed ($tipo){
  if ($("tr.success").find("td:eq(1)").text() != ""){
    if($tipo=="acargo"){
      document.getElementById("solicitud-profesional-acargo").value= $("tr.success").find("td:eq(3)").text() +", "+ $("tr.success").find("td:eq(2)").text() ;
      document.getElementById("solicitud-id_profesional_acargo").value=$("tr.success").find("td:eq(1)").text();

    }else {
      document.getElementById("solicitud-profesional").value= $("tr.success").find("td:eq(3)").text() +", "+ $("tr.success").find("td:eq(2)").text() ;
      document.getElementById("solicitud-id_profesional").value=$("tr.success").find("td:eq(1)").text();
    }
    //vacias el contenido de la variable para que no se anexe con otra eleccion de otro campo
    $('button.close.kv-clear-radio').click();
    $('button.btn.btn-default').click();
    swal({
       title: "Confirmado!",
       text: "Se agrego el profesional",
       type: "success",
       timer: 800
      }
    )
     }
    else {
      swal(
      'No se ha seleccionado a ningún paciente' ,
      'PRESIONAR OK',
      'error'
    );
}


}
function agregarFormularioDiag (){
  const parametro = document.querySelector('.modal-footer .btn-primary').getAttribute('data-parametro-modal');
  if ($("tr.success").find("td:eq(1)").text() != ""){
    document.getElementById("solicitudDiagnostico-codigo"+parametro).value= $("tr.success").find("td:eq(3)").text() ;
    document.getElementById("solicitudDiagnostico-descripcion"+parametro).value= $("tr.success").find("td:eq(2)").text() ;
    document.getElementById("solicitudDiagnostico-id_diagnostico"+parametro).value=$("tr.success").find("td:eq(1)").text();

    //vacias el contenido de la variable para que no se anexe con otra eleccion de otro campo
    $('button.close.kv-clear-radio').click();
    $('button.btn.btn-default').click();

      swal({
         title: "Confirmado!",
         text: "Se agrego el diagnostico",
         type: "success",
         timer: 800
        }
      )
    }
    else {
      swal(
      'No se ha seleccionado a ningún diagnostico' ,
      'PRESIONAR OK',
      'error'
    );
    }
 }
 function enviarParametro(parametro) {
   // Pass the parameter to the modal footer button's data-attribute
   const agregarFormularioButton = document.querySelector('.modal-footer .btn-primary');
    agregarFormularioButton.setAttribute('data-parametro-modal', parametro);

}

</script>

<?php ob_start(); ?>

<script>


 //Crear la clave para la solicitud-diagnostico
 var solicitudDiagnostico_k = <?php echo isset($key) ?
  str_replace('nuevo', '', $key) : 0; ?>;
 //Al hacer click en el boton de nuevo solicitud-diagnostico aumentar en uno la clave
 // y agregar un formulario de solicitud-diagnostico reemplazando la clave __id__ por la nueva clave
 $('#solicitud-nuevo-sol_diagnostico-boton').on('click', function () {
     solicitudDiagnostico_k += 1;
     $('#solicitud-sol_diagnostico')
     .append($('#solicitud-nuevo-sol_diagnostico-block')
     .html().replace(/__id__/g, 'nuevo' + solicitudDiagnostico_k));
   });
//Al hacer click en un botón de eliminar eliminar la fila más cercana
$(document).on('click', '.solicitud-eliminar-sol_diagnostico-boton', function () {
     $(this).closest('.row').remove();
 });
</script>
<?php $this->registerJs(str_replace(['<script>', '</script>'], '', ob_get_clean())); ?>
<?  if (!Yii::$app->request->isAjax){ ?>
   <div class='pull-right'>
      <?=Html::submitButton($model->isNewRecord ? 'Guardar' : 'Actualizar',
       ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
   </div>
<? }
echo $this->render('modals', [
    'modelosDat' => $modelosDat,
]);
    $form = ActiveForm::end();
?>

<!--Fin sección de sol_diagnostico -->
