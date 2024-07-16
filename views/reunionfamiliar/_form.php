<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;

/* @var $this yii\web\View */
/* @var $model app\models\Reunionfamiliar */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reunionfamiliar-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'lugar')->textInput() ?>

    <?= $form->field($model, 'fechahora')->widget(DateControl::classname(), [
        'type' => DateControl::FORMAT_DATETIME,
        'displayFormat' => 'dd/MM/yyyy HH:mm:ss',
        'saveFormat' => 'php:Y-m-d H:i:s',
        'options' => [
            'pluginOptions' => [
                'autoclose' => true,
            ],
        ],
    ])->label("Fecha y hora");?>
    <?= $form->field($model, 'familiares')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'profesionales')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'aceptanacompañamiento')->checkbox(['class' => 'form-check-input-xl']) ?>

    <?= $form->field($model, 'detallesreunion')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'id_solicitud')->hiddenInput(['value'=>$id_solicitud])->label(false) ?>



	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>

</div>
