<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use nex\chosen\Chosen;
use app\models\Tipoactividad;
use kartik\datecontrol\DateControl;



/* @var $this yii\web\View */
/* @var $model app\models\Actividad */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="actividad-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fechahora')->widget(DateControl::classname(), [
        'type' => DateControl::FORMAT_DATETIME,
        'displayFormat' => 'dd/MM/yyyy HH:mm:ss',
        'saveFormat' => 'php:Y-m-d H:i:s',
        'options' => [
            'pluginOptions' => [
                'autoclose' => true,
            ],
        ],
    ])->label("Fecha/Hora de ingreso"); ?>
    <? echo $form->field($model, 'clasificacion')->widget(
      Chosen::className(), [
       'items' => [ 'ASISTENCIAL INDIVIDUAL Y/Ó GRUPAL' => 'ASISTENCIAL INDIVIDUAL Y/Ó GRUPAL',
      'NO ASISTENCIAL' => 'NO ASISTENCIAL', ],
        'placeholder' => 'Selecciona una opción',
       'clientOptions' => [
         'language' => 'es',
         'rtl'=> true,
           'search_contains' => true,
           'single_backstroke_delete' => false,
       ],
      'options' => ['id' => 'actividad-clasificacion'], // Agregar esto asegura que el ID coincida.
     ]);

     $maptipoactividad = ArrayHelper::map(Tipoactividad::Find()->where(['clasificacion' => $model->clasificacion])->all() , 'id', 'descripcion');

     echo $form->field($model, 'id_tipoactividad')->widget(DepDrop::classname(), [
         'data'=>$maptipoactividad,
         'options'=>['id'=>'id_tipoactividad'],
         'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
         'pluginOptions'=>[
           'depends'=>['actividad-clasificacion'],
            'placeholder'=>'Seleccionar actividad...',
            'url'=>Url::to(['/actividad/subcat'])
         ]
     ])->label('Tipo de actividad');
     ?>

    <?= $form->field($model, 'paciente')->textInput() ?>

    <?= $form->field($model, 'observacion')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'id_usuario')->hiddenInput(["value"=>Yii::$app->user->identity->id])->label(false); ?>


	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>

</div>
