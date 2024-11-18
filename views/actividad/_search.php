<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\actividadSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="actividad-search">

    <?php $form = ActiveForm::begin([
        'id' => 'busqueda-fecha',
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1,
            'class' => 'form-inline flex-wrap justify-content-between', // Clase para diseño responsivo
        ],
    ]); ?>

    <div class="form-group mb-2">
        <?= $form->field($model, 'fecha_desde', [
            'options' => ['class' => 'mr-2'],
        ])->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Desde'],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd/mm/yyyy',
                'startView' => 'year',
            ]
        ])->label(false) ?>
    </div>

    <div class="form-group mb-2">
        <?= $form->field($model, 'fecha_hasta', [
            'options' => ['class' => 'mr-2'],
        ])->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Hasta'],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd/mm/yyyy',
                'startView' => 'year',
            ]
        ])->label(false) ?>
    </div>

    <div class="form-group mb-2">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-success mr-2']) ?>
        <?= Html::a('<i class="fas fa-sync-alt"></i> Limpiar', ['index'], [
          'class' => 'btn btn-default',
          'id' => 'btn-limpiar',
          'encode' => false, // Para interpretar etiquetas HTML
      ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
  document.getElementById("btn-limpiar").addEventListener("click", function() {
      document.getElementById("actividadsearch-fecha_desde").value = "";
      document.getElementById("actividadsearch-fecha_hasta").value = "";
    });

</script>
