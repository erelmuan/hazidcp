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
use yii\widgets\MaskedInput;

1?>

   <div class="row telefono">
     <div class="col-lg-2">
       <?=$form->field($telefono, 'numero')->textInput(
         [
           'id' => "telefono-numero{$key}",
           'name' => "Telefonos[$key][numero]",
          'class' =>'form-control'
       ]
         )->label(false);?>

     </div>
     <div class="col-lg-2">
       <?= $form->field($telefono, 'id_empresa')->dropDownList(
         $telefono->getEmpresas(),
       ['id' => "telefono-id_empresa{$key}",
           'name' => "Telefonos[$key][id_empresa]",
          ]
         )->label(false) ;?>
     </div>
     <div class="col-lg-2">
       <?= $form->field($telefono, 'id_tipotel')->dropDownList(
         $telefono->getTipotels(),
       ['id' => "telefono-id_tipotel{$key}",
           'name' => "Telefonos[$key][id_tipotel]",
          ]
         )->label(false) ;?>

    </div>

    <div class="col-lg-2">
      <?=$form->field($telefono, 'fechabaja')
    ->widget(DateControl::classname(), [
      'options' => ['placeholder' => 'Debe agregar una fecha',
              ],
      'type'=>DateControl::FORMAT_DATE,
      'displayFormat' => 'php:d/m/Y',
      'saveFormat' => 'php:Y-m-d',
      'saveOptions' => [
        'name' => "Telefonos[$key][fechabaja]",
        'id' => "telefono-fechabaja{$key}",
            ],
        ])->label(false);
    ?>
    </div>

    	<div class="col-lg-1">
         <?= Html::a('<i class="glyphicon glyphicon-trash" ></i> ' , ($telefono->isNewRecord)?'javascript:void(0);':'', [
           'class' => 'paciente-eliminar-telefono-boton btn btn-danger',
           'title'=>($telefono->isNewRecord)?'Eliminar':'NO SE PUEDE ELIMINAR',
           'disabled'=> ($telefono->isNewRecord)?false:true

            ]) ?>
    	</div>
    </div>
