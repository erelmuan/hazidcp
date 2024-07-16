<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Procedencia */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="procedencia-form">
  <? if($model->asociadoaInternacion()){ ?>
    <span style="color:red"> No se puede realizar la modificación de este registro. <b>(Vinculado a una o más internaciones)</b>.</span>
  <? } ?>
    <?php $form = ActiveForm::begin(); ?>
    <?=$form->field($model, 'nombre')->input("text",['readOnly'=>$model->asociadoaInternacion(),'style'=> 'width:100%; text-transform:uppercase;'])->label('Nombre'); ?>

    <?= $form->field($model, 'contacto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'direccion')->textInput() ?>

	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>

</div>
