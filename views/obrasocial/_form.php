<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Obrasocial */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="obrasocial-form">
  <? if($model->asociadoaObrasocial()){    ?>
    <span style="color:red">   No se puede realizar la modificación de este registro. <b>(Vinculado a uno o más pacientes)</b>.</span>
  <? } ?>
    <?php $form = ActiveForm::begin(); ?>

    <!--si existen pacientes asociados no se puede modificar el sigla  -->
    <?=$form->field($model, 'sigla')->input("text",['readonly' => $model->asociadoaObrasocial() ])->label('Nombre');    ?>
    <!--si existen pacientes asociados no se puede modificar el denominacion  -->
    <?=$form->field($model, 'denominacion')->input("text",['readonly' => $model->asociadoaObrasocial() ])->label('Nombre');   ?>

    <?= $form->field($model, 'direccion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telefono')->textInput() ?>

    <?= $form->field($model, 'paginaweb')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'correoelectronico')->textInput() ?>

    <?= $form->field($model, 'observaciones')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'codigo')->textInput() ?>


	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>

</div>
