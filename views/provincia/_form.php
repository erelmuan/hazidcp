<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Provincia */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="provincia-form">
  <? if($model->asociadoaDomicilio()){    ?>
    <span style="color:red">   No se puede realizar la modificación de este registro. <b>(Vinculado a uno o más domicilios)</b>.</span>
  <? } ?>
    <?php $form = ActiveForm::begin(); ?>
    <!--si existen pacientes asociados no se puede modificar el nombre  -->
    <?=$form->field($model, 'nombre')->input("text",['readonly' => $model->asociadoaDomicilio()])->label('Nombre');    ?>

    <?= $form->field($model, 'codigo')->textInput(['maxlength' => true]) ?>


	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>

</div>
