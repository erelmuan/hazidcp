<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Provincia;
use app\models\Localidad;
use yii\helpers\Url;
use kartik\depdrop\DepDrop;
use app\models\Barrio;
use kartik\date\DatePicker;
use kartik\datecontrol\DateControl;
use kartik\select2\Select2;
?>
   <div class="row sol_diagnostico">
     <div class="col-lg-5">

        <input type="text" id="solicitudDiagnostico-descripcion<?=$key?>"
        class="form-control" name="SolicitudDiagnostico[<?=$key?>][descripcion]"
         value='<?=($sol_diagnostico->diagnostico)?$sol_diagnostico->diagnostico->descripcion:'' ?>' readonly>
     </div>
     <div class="col-lg-2">


        <input type="text" id="solicitudDiagnostico-codigo<?=$key?>"
        class="form-control" name="SolicitudDiagnostico[<?=$key?>][codigo]"
         value='<?=($sol_diagnostico->diagnostico)?$sol_diagnostico->diagnostico->codigo:'' ?>' readonly>
         <?=$form->field($sol_diagnostico, 'id_diagnostico')
         ->hiddenInput(['id' => "solicitudDiagnostico-id_diagnostico{$key}",'name' => "SolicitudDiagnostico[$key][id_diagnostico]", 'value'=>2])
         ->label(false); ?>
     </div>
     <div class="col-lg-1">
       <?=$form->field($sol_diagnostico, 'principal')->checkBox([
       'id' => "solicitudDiagnostico-principal{$key}",
       'name' => "SolicitudDiagnostico[$key][principal]",
         'class' =>'form-control',
         'label' =>false,
          // 'checked' => '1',
         // 'value' => '1',
         'style' => 'width: 50px; height: 30px;', // Added styles for size
     ]); ?>
     </div>
     <div class="col-lg-1">
       <?=$form->field($sol_diagnostico, 'registro_usuario')->hiddenInput(['name' => "SolicitudDiagnostico[$key][registro_usuario]", 'value'=> Yii::$app->user->identity->usuario])->label(false); ?>
       <button onclick="quitarSeleccion(), enviarParametro('<?=$key?>')" title="Busqueda de diagnostico"
       type="button" class="btn btn-primary btn-xs"
       data-toggle="modal" data-target=".bs-diagnostico-modal-lg"
       data-parametro=<?=$key?>
       style="margin-left: 10px; font-size: 20px;">
       <i class="glyphicon glyphicon-search"></i></button>
     </div>
    	<div class="col-lg-1">
        <?=$form->field($sol_diagnostico, 'registro_tiempo')->hiddenInput(['name' => "SolicitudDiagnostico[$key][registro_tiempo]",'value' => date('Y-m-d H:i:s')])->label(false); ?>

        <?= Html::a('<i class="glyphicon glyphicon-trash" ></i> ' ,
          ($sol_diagnostico->isNewRecord)?'javascript:void(0);':'', [
           'class' => 'solicitud-eliminar-sol_diagnostico-boton btn btn-danger',
           'title'=>($sol_diagnostico->isNewRecord)?'Eliminar':'NO SE PUEDE ELIMINAR',
           'disabled'=> ($sol_diagnostico->isNewRecord)?false:true
            ]) ?>

    	</div>

          <?= $form->field($sol_diagnostico,'id_solicitud')->hiddenInput(['name' => "SolicitudDiagnostico[$key][id_solicitud]",'value'=>$model_solicitud->id])->label(false) ?>

          <?= $form->field($sol_diagnostico, 'diag_internacion')->hiddenInput(['name' => "SolicitudDiagnostico[$key][diag_internacion]",'value' => 1])->label(false) ?>

    </div>
