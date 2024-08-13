<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Tipoingreso */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tipoingreso-form">
  <? if($model->asociadoaInternacion()){    ?>
    <span style="color:red">   No se puede realizar la modificación de este registro. <b>(Vinculado a uno o más internaciones)</b>.</span>
  <? } ?>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'descripcion')->textInput(['readOnly'=>$model->asociadoaInternacion()]) ?>


	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>

</div>
