<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Tipoegreso;
use app\models\Tipoingreso;
use app\models\Tipointernacion;
use nex\chosen\Chosen;
use kartik\datecontrol\DateControl;


/* @var $this yii\web\View */
/* @var $model app\models\Internacion */
/* @var $form yii\widgets\ActiveForm */
$maptipoegreso = ArrayHelper::map(Tipoegreso::find()->all() , 'id',  'descripcion'  );
$maptipoingreso = ArrayHelper::map(Tipoingreso::find()->all() , 'id',  'descripcion'  );
$maptipointernacion = ArrayHelper::map(Tipointernacion::find()->all() , 'id',  'descripcion'  );

?>

<div class="internacion-form">

    <?php $form = ActiveForm::begin(); ?>
    <?=$form->field($model, 'id_tipointernacion')->widget(
      Chosen::className(), [
       'items' => $maptipointernacion,
        'placeholder' => 'Selecciona una opción',
       'clientOptions' => [
         'language' => 'es',
         'rtl'=> true,
           'search_contains' => true,
           'single_backstroke_delete' => false,
       ],])->label("Tipo de internación");?>
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

    <?=$form->field($model, 'id_tipoingreso')->widget(
      Chosen::className(), [
       'items' => $maptipoingreso,
        'placeholder' => 'Selecciona una opción',
       'clientOptions' => [
         'language' => 'es',
         'rtl'=> true,
           'search_contains' => true,
           'single_backstroke_delete' => false,
       ],]);?>


    <?= $form->field($model, 'id_solicitud')->hiddenInput(['value'=>$id_solicitud])->label(false) ?>

	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>

</div>
