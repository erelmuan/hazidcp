<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Tipoconsulta */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tipoconsulta-form">
  <? if($model->asociadoaAtencion()){    ?>
    <span style="color:red">   No se puede realizar la modificación de este registro. <b>(Vinculado a uno o más atenciones)</b>.</span>
  <? } ?>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'descripcion')->textInput(['readOnly'=>$model->asociadoaAtencion()]) ?>

    <?= $form->field($model, 'detalles')->textarea(['rows' => 6]) ?>


	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>

</div>
