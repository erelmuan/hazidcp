<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\depdrop\DepDrop;
use kartik\date\DatePicker;
use kartik\datecontrol\DateControl;
?>
   <div class="row pacienteObrasocial">
     <div class="col-lg-2">
       <?= $form->field($pacienteObrasocial, 'id_obrasocial')->dropDownList(
         $pacienteObrasocial->getObrasociales(),
       ['id' => "pacienteObrasocial-id_obrasocial{$key}",
           'name' => "PacienteObrasocials[$key][id_obrasocial]",
          ]
         )->label(false) ;?>
     </div> 
     <div class="col-lg-2">
       <?= $form->field($pacienteObrasocial, 'nroafiliado')->textInput(
     [ 'id' => "pacienteObrasocial-nroafiliado{$key}",
       'name' => "PacienteObrasocials[$key][nroafiliado]",
     ])->label(false) ?>
     </div>
     <div class="col-lg-2">

     <?=$form->field($pacienteObrasocial, 'fecha_baja')
       ->widget(DateControl::classname(), [
         'options' => ['placeholder' => 'Debe agregar una fecha',
                 ],
         'type'=>DateControl::FORMAT_DATE,
         'displayFormat' => 'php:d/m/Y',
         'saveFormat' => 'php:Y-m-d',
         'saveOptions' => [
           'name' => "PacienteObrasocials[$key][fecha_baja]",
           'id' => "pacienteObrasocial-fecha_baja{$key}",
               ],
           ])->label(false);
   ?>
     </div>

    	<div class="col-lg-1">
         <?= Html::a('<i class="glyphicon glyphicon-trash" ></i> ' , ($pacienteObrasocial->isNewRecord)?'javascript:void(0);':'', [
           'class' => 'paciente-eliminar-pacienteObrasocial-boton btn btn-danger',
           'title'=>($pacienteObrasocial->isNewRecord)?'Eliminar':'NO SE PUEDE ELIMINAR',
           'disabled'=> ($pacienteObrasocial->isNewRecord)?false:true

            ]) ?>
    	</div>
    </div>
