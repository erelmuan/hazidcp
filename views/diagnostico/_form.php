<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Diagnostico */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="diagnostico-form">
  <? if($model->asociadoaSolicitud()){    ?>
    <span style="color:red">   No se puede realizar la modificación de este registro. <b>(Vinculado a una o más solicitudes)</b>.</span>
  <? } ?>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'descripcion')->textInput(['readOnly'=>$model->asociadoaSolicitud()]) ?>
    <?= $form->field($model, 'codigo')->textInput(['readOnly'=>$model->asociadoaSolicitud()]) ?>

	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>

</div>
