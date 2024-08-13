<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Prestador */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="prestador-form">
  <? if($model->asociadoInternacion){ ?>
    <span style="color:red"> No se puede realizar la modificación de este registro. <b>(Vinculado a una internación)</b>.</span>
  <? } ?>
    <?php $form = ActiveForm::begin(); ?>

    <? if($model->asociadoInternacion){
            echo  $form->field($model, 'nombre')->input("text",['readonly' => true])->label('Nombre');
          }else {
            echo  $form->field($model, 'nombre')->input("text",['style'=> 'width:100%; text-transform:uppercase;'])->label('Nombre');
          }
    ?>
    <? if($model->asociadoInternacion){
            echo  $form->field($model, 'apellido')->input("text",['readonly' => true])->label('Apellido');
          }else {
            echo  $form->field($model, 'apellido')->input("text",['style'=> 'width:100%; text-transform:uppercase;'])->label('Apellido');
          }
    ?>

    <?= $form->field($model, 'id_tipodoc')->dropDownList($model->getTipodocs())->label('Tipo de documento') ;?>

    <?=$form->field($model, 'numdocumento')->input("text",['readonly' => $model->asociadoInternacion,'style'=> 'width:100%; text-transform:uppercase;'])->label('Numero de doc.');?>


	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>

</div>
