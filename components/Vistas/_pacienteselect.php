<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin();
?>

<b>Seleccione los pacientes que desea visualizar</b>
&nbsp;<input type="checkbox" id="seleccionarTodos"> Seleccionar Todos
<br><br>

<?php
// Definir las opciones para los checkboxes (aquí se deben definir los valores y etiquetas correctas)
$opcionesCheckbox = [
    'pacinternados' => 'Pacientes Internados',
    'pacsininternacion' => 'Pacientes sin Internación',
    'pacalta' => 'Pacientes de Alta',
];

// Renderizar la lista de checkboxes
echo Html::checkboxList(
    'seleccion', // Nombre del campo
    $seleccionados, // Valores seleccionados previamente
    $opcionesCheckbox, // Opciones (clave => etiqueta)
    [
        'class' => 'ui-sortable',
        'id' => 'sortable',
        'item' => function ($index, $label, $name, $checked, $value) use ($seleccionados) {
            $isChecked = in_array($value, $seleccionados);
            return Html::checkbox($name, $isChecked, [
                'value' => $value,
                'label' => '&nbsp;' . $label . '&nbsp;' . '&nbsp;' . '&nbsp;' . '&nbsp;' . '&nbsp;',
                'labelOptions' => ['class' => 'ui-sortable-handle']
            ]);
        }
    ]
);
?>

<?php ActiveForm::end(); ?>

<script>
$(document).ready(function() {
    // Manejar el evento de cambio del checkbox "Seleccionar Todos"
    $("#seleccionarTodos").change(function() {
        $("input[name='seleccion[]']").prop("checked", this.checked);
    });
});
</script>
