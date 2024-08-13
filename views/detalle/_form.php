<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Tipoegreso;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\models\Detalle */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="detalle-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'descripcion')->textInput() ?>

    <?= $form->field($model, 'id_tipoegreso')->dropDownList(ArrayHelper::map(Tipoegreso::find()->orderBy(['tipoegreso.descripcion'=>SORT_ASC])->all(), 'id','descripcion'))->label('Tipo de egreso') ; ?>


	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>

</div>
