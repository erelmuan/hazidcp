<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Internacion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="internacion-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_tipointernacion')->textInput() ?>

    <?= $form->field($model, 'fechahoraingreso')->textInput() ?>

    <?= $form->field($model, 'id_tipoingreso')->textInput() ?>

    <?= $form->field($model, 'fechahoraegreso')->textInput() ?>

    <?= $form->field($model, 'id_tipoegreso')->textInput() ?>

    <?= $form->field($model, 'id_solicitud')->textInput() ?>


	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>

</div>
