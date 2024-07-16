<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Domicilio */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="domicilio-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'direccion')->textInput() ?>

    <?= $form->field($model, 'id_barrio')->textInput() ?>

    <?= $form->field($model, 'id_paciente')->textInput() ?>

    <?= $form->field($model, 'id_provincia')->textInput() ?>

    <?= $form->field($model, 'id_localidad')->textInput() ?>

    <?= $form->field($model, 'id_tipodom')->textInput() ?>

    <?= $form->field($model, 'fechabaja')->textInput() ?>


	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>

</div>
