<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $model app\models\Profesional */
/* @var $form yii\widgets\ActiveForm */
?>
<div  class="x_panel">

   <div class="x_title">
       <h2> <?=$model->isNewRecord ? "<i class='glyphicon glyphicon-plus'></i> NUEVO PROFESIONAL" : "<i class='glyphicon glyphicon-pencil'></i> ACTUALIZAR PACIENTE" ; ?>
       </h2>
       <div class="clearfix">
           <div class="nav navbar-right panel_toolbox">
               <?=Html::button('<i class="glyphicon glyphicon-arrow-left"></i> Atrás',array('name' => 'btnBack','onclick'=>'js:history.go(-1);returnFalse;','id'=>'botonAtras')); ?>
       </div>
     </div>
<div class="profesional-form">
  <? if($model->asociadoInternacion){ ?>
    <span style="color:red">  No se puede realizar la modificación de este registro. <b>(Vinculado a una internación)</b>.</span>
  <? } ?>
  <div class="col-sm-10 pb-3">
     <label>Buscar prestador:<span id='prestador'> </span>
         <button onclick="quitarSeleccion() "title="Busqueda de prestadores" type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target=".bs-prestador-modal-lg" style="margin-left: 10px;"  <?php if ($model->asociadoInternacion): ?>disabled<?php endif; ?>><i class="glyphicon glyphicon-search" ></i></button>
       </label>
 </div>

    <?php $form = ActiveForm::begin(); ?>
    <?=$form->field($model, 'id_prestador')->hiddenInput()->label(false); ?>
    <div class="col-sm-4 pb-3">
      <?= $form->field($model, 'apellido')->textInput(['maxlength' => true, 'readonly'=>true]) ?>
    </div>
    <div class="col-sm-4 pb-3">
      <?= $form->field($model, 'nombre')->textInput(['maxlength' => true ,'readonly'=>true]) ?>
    </div>
    <div class="col-sm-4 pb-3">
      <?= $form->field($model, 'tipodoc')->textInput(['maxlength' => true, 'readonly'=>true]) ?>
    </div>
    <div class="col-sm-4 pb-3">
      <?= $form->field($model, 'numdocumento')->textInput(['maxlength' => true, 'readonly'=>true]) ?>
   </div>
    <div class="col-sm-4 pb-3">
      <?= $form->field($model, 'matricula')->textInput() ?>
   </div>
    <div class="col-sm-2 pb-3">
      <?= $form->field($model, 'id_especialidad')->dropDownList($model->getEspecialidades())->label('Especialidad') ;?>
   </div>
   <div class="col-sm-2 pb-3">
     <div class="form-group">
       <?= Html::activeLabel($model, 'visualizar', ['class' => 'control-label']) ?>
       <div>
         <?=$form->field($model, 'visualizar')->checkBox([
           'class' =>'form-control',
           'label' =>false,
            // 'checked' => '1',
           // 'value' => '1',
           'style' => 'width: 50px; height: 30px;', // Added styles for size
       ]); ?>
       </div>
   </div>
  </div>

   <div class="col-sm-4 pb-3">
      <label>Buscar usuario:<span id='usuario'> </span>
          <button onclick="quitarSeleccion() " title="Busqueda de usuarios" type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target=".bs-usuario-modal-lg" style="margin-left: 10px;"><i class="glyphicon glyphicon-search" ></i></button>
        </label>
  </div>
   </div>
     <div class="form-group field-profesional-usuario">
     <label class="control-label" for="profesional-usuario">Usuario</label>
      <input type="text" id="profesional-usuario" class="form-control" style="width: 250px;" value='<?=($model->usuario)?$model->usuario->usuario:'' ?>' readonly/>     <div class="help-block"></div>
     </div>
      <?=$form->field($model, 'id_usuario')->hiddenInput()->label(false); ?>

	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>
<div class="x_content">
       <div class="x_content">
             <div class="modal fade bs-usuario-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
               <div class="modal-dialog modal-lg">
                 <div class="modal-content">
                   <div class="modal-body">
                     <div class="usuario-index">
                         <div id="ajaxCrudDatatable">
                           <?=GridView::widget([
                               'id'=>'crud-usuario',
                               'dataProvider' => $modelosDat['dataProviderUsu'],
                               'filterModel' => $modelosDat['searchModelUsu'],
                               'pjax'=>true,
                               'columns' => require(__DIR__.'/_columnsUsuario.php'),
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
                       <button type="button"  onclick='agregarFormularioUsu();' class="btn btn-primary">Agregar al formulario</button>
                     </div>
               </div>
             </div>
           </div>
       </div>
     </div>
    </div>

    <div class="x_content">
           <div class="x_content">
                 <div class="modal fade bs-prestador-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                   <div class="modal-dialog modal-lg">
                     <div class="modal-content">
                       <div class="modal-body">
                         <div class="prestador-index">
                             <div id="ajaxCrudDatatable">
                               <?=GridView::widget([
                                   'id'=>'crud-prestador',
                                   'dataProvider' => $modelosDat['dataProviderPrest'],
                                   'filterModel' => $modelosDat['searchModelPrest'],
                                   'pjax'=>true,
                                   'columns' => require(__DIR__.'/_columnsPrestador.php'),
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
                           <button type="button"  onclick='agregarFormularioPrest();' class="btn btn-primary">Agregar al formulario</button>
                         </div>
                   </div>
                 </div>
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
function agregarFormularioPrest (){
// Vaciamos los campos
  document.getElementById("profesional-id_prestador").value="";
  document.getElementById("profesional-nombre").value=  "" ;
  document.getElementById("profesional-apellido").value= "" ;
  document.getElementById("profesional-tipodoc").value=  "";
  document.getElementById("profesional-numdocumento").value=  "";

  document.getElementById("profesional-id_prestador").value=$("tr.success").find("td:eq(1)").text();
  document.getElementById("profesional-nombre").value=  $("tr.success").find("td:eq(2)").text() ;
  document.getElementById("profesional-apellido").value=  $("tr.success").find("td:eq(3)").text() ;
  document.getElementById("profesional-tipodoc").value=  $("tr.success").find("td:eq(4)").text() ;
  document.getElementById("profesional-numdocumento").value=  $("tr.success").find("td:eq(5)").text() ;

  //vacias el contenido de la variable para que no se anexe con otra eleccion de otro campo
  $('button.close.kv-clear-radio').click();
  swal(
  'Se agrego el prestador' ,
  'PRESIONAR OK',
  'success'
  )
  $('button.btn.btn-default').click();

}


function agregarFormularioUsu (){
  document.getElementById("profesional-usuario").value="";
  document.getElementById("profesional-id_usuario").value="";
  document.getElementById("profesional-usuario").value=  $("tr.success").find("td:eq(2)").text() ;
  document.getElementById("profesional-id_usuario").value=$("tr.success").find("td:eq(1)").text();
  //vacias el contenido de la variable para que no se anexe con otra eleccion de otro campo
  $('button.close.kv-clear-radio').click();
  swal(
  'Se agrego el usuario' ,
  'PRESIONAR OK',
  'success'
  )
  $('button.btn.btn-default').click();

}

</script>
