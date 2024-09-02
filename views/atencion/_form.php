<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use nex\chosen\Chosen;

// use kartik\widgets\TimePicker;
use yii\helpers\ArrayHelper;
use app\models\Servicio;
use app\models\Tipoconsulta;
use app\models\Solicitud;


/* @var $this yii\web\View */
/* @var $model app\models\Atencion */
/* @var $form yii\widgets\ActiveForm */
$mapservicio = ArrayHelper::map(Servicio::find()->all() , 'id',  'nombre'  );
$maptipoconsulta = ArrayHelper::map(Tipoconsulta::find()->all() , 'id',  'descripcion'  );


?>
<div class="atencion-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_usuario')->hiddenInput(["value"=>Yii::$app->user->identity->id])->label(false); ?>

    <?
    echo $form->field($model, 'id_servicio')->widget(
      Chosen::className(), [
       'items' => $mapservicio,
        'placeholder' => 'Selecciona una opción',
       'clientOptions' => [
         'language' => 'es',
         'rtl'=> true,
           'search_contains' => true,
           'single_backstroke_delete' => false,
       ],])->label("Servicio");
    ?>

    <?= $form->field($model, 'fechahora')->widget(DateControl::classname(), [
        'type' => DateControl::FORMAT_DATETIME,
        'displayFormat' => 'dd/MM/yyyy HH:mm:ss',
        'saveFormat' => 'php:Y-m-d H:i:s',
        'options' => [
            'pluginOptions' => [
                'autoclose' => true,
            ],
        ],
    ])->label("Fecha y hora"); ?>


    <?=$form->field($model, 'id_tipoconsulta')->widget(
      Chosen::className(), [
       'items' => $maptipoconsulta,
        'placeholder' => 'Selecciona una opción',
       'clientOptions' => [
         'language' => 'es',
         'rtl'=> true,
           'search_contains' => true,
           'single_backstroke_delete' => false,
       ],])->label("Tipo de consulta");
    ?>

    <?= $form->field($model, 'respuesta')->textInput(); ?>

    <?= $form->field($model, 'personaasesorada')->textInput(); ?>

    <?= $form->field($model, 'vinculo')->textInput() ?>

    <?= $form->field($model, 'paciente')->textInput() ?>

    <?= $form->field($model, 'detalles')->textarea(['rows' => 6]) ?>

	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>

</div>
