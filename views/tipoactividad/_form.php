<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Tipoactividad */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tipoactividad-form">
  <? if($model->asociadoaActividad()){    ?>
    <span style="color:red">   No se puede realizar la modificación de este registro. <b>(Vinculado a uno o más actividades)</b>.</span>
  <? } ?>
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'clasificacion')->dropDownList([
        'ASISTENCIAL INDIVIDUAL Y/Ó GRUPAL' => 'ASISTENCIAL INDIVIDUAL Y/Ó GRUPAL',
        'NO ASISTENCIAL' => 'NO ASISTENCIAL',
    ], ['prompt' => '', 'disabled' => $model->asociadoaActividad()]) ?>
    <?= $form->field($model, 'descripcion')->textInput(['readOnly'=>$model->asociadoaActividad()]) ?>
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>

</div>
