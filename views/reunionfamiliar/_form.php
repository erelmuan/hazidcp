<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use nex\chosen\Chosen;
use yii\helpers\ArrayHelper;
use app\models\Plantillareunionfamiliar;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Reunionfamiliar */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reunionfamiliar-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'lugar')->textInput(['style'=> 'width:100%; text-transform:uppercase;','placeholder'=>'ESCRIBA AQUÍ (SE CONVERTIRÁ EN MAYÚSCULAS)']) ?>
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
    <?= $form->field($model, 'familiares')->textarea(['rows' => 6,'style'=> 'width:100%; text-transform:uppercase;','placeholder'=>'ESCRIBA AQUÍ (SE CONVERTIRÁ EN MAYÚSCULAS)']) ?>

    <?= $form->field($model, 'profesionales')->textarea(['rows' => 6,'style'=> 'width:100%; text-transform:uppercase;','placeholder'=>'ESCRIBA AQUÍ (SE CONVERTIRÁ EN MAYÚSCULAS)']) ?>

    <?= $form->field($model, 'aceptanacompañamiento')->checkBox([
      'class' => 'form-control',
      'style' => 'width: 50px; height: 30px;', // Estilos para tamaño del checkbox
  ],
      false // Evita que el label envuelva el input
  )->label(null, ['style' => 'display:inline; margin-left:10px;']); // Ajuste de la etiqueta para que esté en línea
  ?>

    <?  echo (Html::label('Código reunion familiar', 'username', ['class' => 'form-group field-plantilla has-success']));    ?>

    <button type="button" class="btn btn-primary btn-xs" onclick="quitarSeleccion()" data-toggle="modal"
        data-target=".bs-plantilla-modal-lg" style="margin-left: 10px;"><i
            class="glyphicon glyphicon-plus"></i></button>

    <button type="button" class="btn btn-danger btn-xs" onclick="limpiarDetalles()"><i
            class="glyphicon glyphicon-minus"></i></button>
    <?   $mapPlantilla = ArrayHelper::map(Plantillareunionfamiliar::find()->all() , 'id',  'codigo'  );

      echo $form->field($model, 'id_plantillareunionfliar')->widget(
      Chosen::className(), [
       'items' => $mapPlantilla,
       'placeholder' => 'Seleccionar código...',
       'clientOptions' => [
           'search_contains' => true,
           'no_results_text' => "¡Vaya, no se encontró nada!",
       ],
       'options' => [
           'onchange' => 'onEnviarPlantilla(this.value)',
       ],
      ]
      )->label(false);
             ?>
      </br>
      </br>
    <?= $form->field($model, 'detallesreunion')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'id_solicitud')->hiddenInput(['value'=>$id_solicitud])->label(false) ?>



	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

  <?= $this->render('modals', [
      'model' => $model,
      'search' => $search,
      'provider' => $provider,

  ]) ?>

    <?php ActiveForm::end(); ?>

</div>

<script>
function quitarSeleccion() {
    $('span.kv-clear-radio').click();

}
function limpiarDetalles() {
    $("textarea#reunionfamiliar-detallesreunion.form-control").val('');
}
function onEnviarPlantilla(val) {
    var textArea = document.getElementById('reunionfamiliar-detallesreunion');

    $.ajax({
        url: '<?php echo Url::to(['/plantillareunionfamiliar/buscaregistro']) ?>',
        type: 'post',
        data: {
            id: val
        },
        success: function(data) {
            var current_value = textArea.value;
            var content = JSON.parse(data);
            if (current_value.trim() == "") {
                document.getElementById("reunionfamiliar-detallesreunion").value = content[0].descripcion;
            } else {
                document.getElementById("reunionfamiliar-detallesreunion").value = current_value + "\r\n" + content[0]
                    .descripcion;
            }
        }

    });
}


$('.modal').on("hidden.bs.modal", function (e) {
    if($('.modal:visible').length)
    {
        $('.modal-backdrop').first().css('z-index', parseInt($('.modal:visible').last().css('z-index')) - 10);
        $('body').addClass('modal-open');
    }
});
function cerrarSoloSegundoModal() {
    $('#modal-plantilla').modal('hide');  // Solo cierra el segundo modal
}

function agregarFormulario() {
    if ($("tr.success").find("td:eq(1)").text() != "") {
        var textArea = document.getElementById('reunionfamiliar-detallesreunion');
        if (textArea.value.trim() == "") {
            $("textarea#reunionfamiliar-detallesreunion.form-control").val($("tr.success").find("td:eq(2)").text());
        } else {
            $("textarea#reunionfamiliar-detallesreunion.form-control").val(textArea.value + "\r\n" + $("tr.success").find("td:eq(2)")
                .text());
        }
        //vacias el contenido de la variable para que no se anexe con otra eleccion de otro campo
        $('span.kv-clear-radio').click();
        cerrarSoloSegundoModal();

    } else {
        swal(
            'No se ha seleccionado a ningún registro',
            'PRESIONAR OK',
            'error'
        );
    }

}

</script>
