<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Registrosesion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="registrosesion-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_usuario')->textInput() ?>

    <?= $form->field($model, 'iniciosesion')->textInput() ?>

    <?= $form->field($model, 'ip')->textInput() ?>

    <?= $form->field($model, 'informacionusuario')->textInput() ?>

    <?= $form->field($model, 'cookie')->textInput() ?>

    <?= $form->field($model, 'cierresesion')->textInput() ?>


	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>

</div>
