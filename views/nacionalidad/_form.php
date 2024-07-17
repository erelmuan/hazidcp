<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Nacionalidad */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="nacionalidad-form">
  <? if($model->asociadoaPaciente()){    ?>
    <span style="color:red">   No se puede realizar la modificación de este registro. <b>(Vinculado a uno o más pacientes)</b>.</span>
  <? } ?>
    <?php $form = ActiveForm::begin(); ?>
    <!--si existen pacientes asociados no se puede modificar el nombre  -->

    <?=$form->field($model, 'gentilicio')->input("text",['readonly' => $model->asociadoaPaciente(),'style'=> 'width:100%; text-transform:uppercase;'])->label('Gentilicio');  ?>

	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>

</div>