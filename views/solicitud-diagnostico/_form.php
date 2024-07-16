<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\SolicitudDiagnostico;
use yii\bootstrap\Modal;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\SolicitudDiagnostico */
/* @var $form yii\widgets\ActiveForm */
CrudAsset::register($this);
?>
<div class="x_panel">
    <div class="x_title">
        <h2> <?=$model->isNewRecord ? "<i class='glyphicon glyphicon-plus'></i> NUEVO DIAGNOSTICO (SOLO INTERNACIÓN)" : "<i class='glyphicon glyphicon-pencil'></i> ACTUALIZAR DIAGNOSTICO (SOLO INTERNACIÓN)" ; ?>
        </h2>
        <div class="clearfix">
            <div class="nav navbar-right panel_toolbox">
              <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?echo Html::button('<i class="glyphicon glyphicon-arrow-left"></i> Atrás',array('name' => 'btnBack','onclick'=>'js:history.go(-1);returnFalse;','id'=>'botonAtras')); ?></div>
            </div>
        </div>
    </div>
</div>
<?= $this->render('/solicitud/_encabezado', [
    'model_solicitud' => $model_solicitud,
]) ?>



<?php $form = ActiveForm::begin(); ?>


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
           foreach ($model_solicitud->solicitudDiagnosticosInternaciones as $key => $_sol_diagnostico) {
             //Para cada sol_diagnostico renderizar el formulario de sol_diagnostico
             //Si el sol_diagnostico está vacío colocar 'nuevo' como clave, si no asignar el id del diagnostico
             echo '<tr>';
             echo $this->render('_form-sol_diagnostico', [
               'key' => $_sol_diagnostico->isNewRecord ? (strpos($key, 'nuevo') !== false ? $key : 'nuevo' . $key) : $_sol_diagnostico->id,
               'form' => $form,
               'sol_diagnostico' => $_sol_diagnostico,
               'model_solicitud' => $model_solicitud,
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
                 'model_solicitud' => $model_solicitud,

             ]);
             echo '</div>';
           ?>



</div>




	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>

</div>
<!-- Modal -->
<div class="x_content">
  <div class="modal fade bs-diagnostico-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-body">
           <span id="modal-parametro">.</span>
           <div class="diagnostico-index">
              <div id="ajaxCrudDatatable">
                <?=GridView::widget([
                    'id'=>'crud-diagnostico',
                    'dataProvider' => $modelosDat['dataProviderDiag'],
                    'filterModel' => $modelosDat['searchModelDiag'],
                    'pjax'=>true,
                    'columns' => require(__DIR__.'/../solicitud/_columnsDiagnostico.php'),
                    'toolbar'=> [

                    ],
                    'panel' => [
                        'type' => 'primary',
                        'heading'=> false,
                    ]
                ])?>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="button" onclick="agregarFormularioDiag()" class="btn btn-primary">Agregar al formulario</button>  </div>
    </div>
  </div>
</div>
</div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>



<script>
function quitarSeleccion (){
  $('span.kv-clear-radio').click();

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
