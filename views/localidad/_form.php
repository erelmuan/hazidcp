<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Provincia;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model app\models\Localidad */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="localidad-form">
  <? if($model->asociadoaDomicilio()){    ?>
    <span style="color:red">   No se puede realizar la modificación de este registro. <b>(Vinculado a uno o más domicilios)</b>.</span>
  <? } ?>
    <?php $form = ActiveForm::begin(); ?>
    <!--si existen pacientes asociados no se puede modificar el nombre  -->
    <? if($model->asociadoaDomicilio()){
          echo $form->field($model, 'id_provincia')->hiddenInput()->label(false);
          echo  $form->field($model, 'provincia')->input("text",['readonly' => true , "value"=>$model->provincia->nombre])->label('Provincia');
          }else {
            echo $form->field($model, 'id_provincia')->dropDownList(ArrayHelper::map(Provincia::find()->all(), 'id','nombre'))->label('Provincia') ;
        }
    ?>

    <!--si existen pacientes asociados no se puede modificar el nombre  -->
    <?=$form->field($model, 'nombre')->input("text",['readonly' => $model->asociadoaDomicilio(),'style'=> 'width:100%; text-transform:uppercase;'])->label('Nombre');
    ?>

    <?= $form->field($model, 'codigopostal')->textInput() ?>


	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>

</div>
