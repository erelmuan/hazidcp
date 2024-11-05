<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Tipoegreso;
use app\models\Tipoingreso;
use app\models\Tipointernacion;
use nex\chosen\Chosen;
use kartik\datecontrol\DateControl;
use kartik\depdrop\DepDrop;
use app\models\Detalle;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Internacion */
/* @var $form yii\widgets\ActiveForm */
$maptipoegreso = ArrayHelper::map(Tipoegreso::find()->all() , 'id',  'descripcion'  );
$maptipoingreso = ArrayHelper::map(Tipoingreso::find()->all() , 'id',  'descripcion'  );
$maptipointernacion = ArrayHelper::map(Tipointernacion::find()->all() , 'id',  'descripcion'  );

?>

<div class="internacion-form">

    <?php $form = ActiveForm::begin(); ?>
    <? if ($tipo=='fechahoraingreso') { ?>
    <?=$form->field($model, 'id_tipointernacion')->widget(
      Chosen::className(), [
       'items' => $maptipointernacion,
        'placeholder' => 'Selecciona una opción',
       'clientOptions' => [
         'language' => 'es',
         'rtl'=> true,
           'search_contains' => false,
           'single_backstroke_delete' => false,
       ],])->label("Tipo de internación");?>
     <?   } ?>
     <? if ($tipo=='fechahoraingreso') { ?>
       <?= $form->field($model, 'fechahoraingreso')->widget(DateControl::classname(), [
           'type' => DateControl::FORMAT_DATETIME,
           'displayFormat' => 'dd/MM/yyyy HH:mm:ss',
           'saveFormat' => 'php:Y-m-d H:i:s',
           'options' => [
               'pluginOptions' => [
                   'autoclose' => true,
               ],
           ],
       ])->label("Fecha/Hora de ingreso"); ?>
     <?   } ?>
     <? if ($tipo=='fechahoraingreso') { ?>
    <? echo $form->field($model, 'id_tipoingreso')->widget(
      Chosen::className(), [
       'items' => $maptipoingreso,
        'placeholder' => 'Selecciona una opción',
       'clientOptions' => [
         'language' => 'es',
         'rtl'=> true,
           'search_contains' => true,
           'single_backstroke_delete' => false,
       ],]);?>

     <?   } ?>
     <? if ($tipo=='fechahoraegreso') { ?>
       <?= $form->field($model, 'fechahoraegreso')->widget(DateControl::classname(), [
           'type' => DateControl::FORMAT_DATETIME,
           'displayFormat' => 'dd/MM/yyyy HH:mm:ss',
           'saveFormat' => 'php:Y-m-d H:i:s',
           'options' => [
               'pluginOptions' => [
                   'autoclose' => true,
               ],
           ],
       ])->label("Fecha/Hora de egreso"); ?>
     <?   } ?>
     <? if ($tipo=='fechahoraegreso') { ?>
      <? echo $form->field($model, 'id_tipoegreso')->widget(
        Chosen::className(), [
         'items' => $maptipoegreso,
          'placeholder' => 'Selecciona una opción',
         'clientOptions' => [
           'language' => 'es',
           'rtl'=> true,
             'search_contains' => true,
             'single_backstroke_delete' => false,
         ],
        'options' => ['id' => 'internacion-id_tipoegreso'], // Agregar esto asegura que el ID coincida.
       ]);
         $mapdetalle = ArrayHelper::map(Detalle::Find()->where(['id_tipoegreso' => $model->id_tipoegreso])->all() , 'id', 'descripcion');

          echo $form->field($model, 'id_detalle')->widget(DepDrop::classname(), [
              'data'=>$mapdetalle,
              'options'=>['id'=>'id_detalle'],
              'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
              'pluginOptions'=>[
                'depends'=>['internacion-id_tipoegreso'],
                 'placeholder'=>'Seleccionar detalle...',
                 'url'=>Url::to(['/internacion/subcat'])
              ]
          ])->label('Detalle');

         } ?>

    <?= $form->field($model, 'id_solicitud')->hiddenInput(['value'=>$model->id_solicitud])->label(false) ?>

	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>

</div>
