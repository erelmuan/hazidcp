<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use nex\chosen\Chosen;
use app\models\Tipoactividad;
use kartik\datecontrol\DateControl;
use yii\jui\AutoComplete;

/* @var $this yii\web\View */
/* @var $model app\models\Actividad */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="actividad-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fechahora')->widget(DateControl::classname(), [
        'type' => DateControl::FORMAT_DATETIME,
        'displayFormat' => 'dd/MM/yyyy HH:mm:ss',
        'saveFormat' => 'php:Y-m-d H:i:s',
        'options' => [
            'pluginOptions' => [
                'autoclose' => true,
            ],
        ],
    ])->label("Fecha/Hora de ingreso"); ?>
    <? echo $form->field($model, 'clasificacion')->widget(
      Chosen::className(), [
       'items' => [ 'ASISTENCIAL INDIVIDUAL Y/Ó GRUPAL' => 'ASISTENCIAL INDIVIDUAL Y/Ó GRUPAL',
      'NO ASISTENCIAL' => 'NO ASISTENCIAL', ],
        'placeholder' => 'Selecciona una opción',
       'clientOptions' => [
         'language' => 'es',
         'rtl'=> true,
           'search_contains' => true,
           'single_backstroke_delete' => false,
       ],
      'options' => ['id' => 'actividad-clasificacion'], // Agregar esto asegura que el ID coincida.
     ]);

     $maptipoactividad = ArrayHelper::map(Tipoactividad::Find()->where(['clasificacion' => $model->clasificacion])->all() , 'id', 'descripcion');

     echo $form->field($model, 'id_tipoactividad')->widget(DepDrop::classname(), [
         'data'=>$maptipoactividad,
         'options'=>['id'=>'id_tipoactividad'],
         'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
         'pluginOptions'=>[
           'depends'=>['actividad-clasificacion'],
            'placeholder'=>'Seleccionar actividad...',
            'url'=>Url::to(['/actividad/subcat'])
         ]
     ])->label('Tipo de actividad');
     ?>

     <div class="input-group">
       <?= AutoComplete::widget([
          'clientOptions' => [
              'source' => Url::to(['actividad/autocomplete']), // URL de los resultados de autocompletado
              'minLength' => 4, // Mínimos caracteres para activar el autocompletado
              'select' => new \yii\web\JsExpression('function(event, ui) {
                  $("#actividad-id_paciente").val(ui.item.id_paciente); // Asignar ID del paciente a campo oculto
                  $("#actividad-pacienteint").val(ui.item.value); // Asignar el valor del autocompletado
                  $("#autocomplete-pacienteint").prop("disabled", true); // Bloquear el campo después de selección
              }'),
          ],
          'options' => [
              'id' => 'autocomplete-pacienteint', // ID único del campo
              'class' => 'form-control',
              'autocomplete' => 'off',
              'placeholder' => 'Ingrese parte del nombre o apellido del paciente',
          ],
      ]) ?>
       <?= $form->field($model, 'pacienteint')->hiddenInput([
           'id' => 'actividad-pacienteint', // ID único para el campo oculto
       ])->label(false); ?>

         <span class="input-group-btn">
             <button type="button" id="reset-pacienteint" class="btn btn-danger" title="Editar o borrar selección">
                 <i class="glyphicon glyphicon-remove"></i>
             </button>
         </span>
     </div>

     <?= $form->field($model, 'id_paciente')->hiddenInput([
         'id' => 'actividad-id_paciente', // ID único para el campo oculto
     ])->label(false); ?>


    <?= $form->field($model, 'observacion')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'id_usuario')->hiddenInput(["value"=>Yii::$app->user->identity->id])->label(false); ?>


	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>

</div>

<?php
$this->registerCss("
    .ui-autocomplete {
        z-index: 1051;
    }
");
$this->registerJs("
    $('#reset-pacienteint').on('click', function() {
        // Borrar el valor del input y desbloquearlo
        $('#pacienteint-autocomplete').val('').prop('disabled', false);
        // Borrar el valor del campo oculto
        $('#actividad-id_paciente').val('');
    });
", \yii\web\View::POS_READY);
?>
