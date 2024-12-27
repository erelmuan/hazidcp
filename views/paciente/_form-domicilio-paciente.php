<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Provincia;
use app\models\Localidad;
use yii\helpers\Url;
use kartik\depdrop\DepDrop;
use app\models\Barrio;
use kartik\date\DatePicker;
use kartik\datecontrol\DateControl;
use kartik\select2\Select2;
?>
<style>
.suggestions-list {
  position: absolute;
  z-index: 1000;
  background: #f9f9f9; /* Fondo claro */
  list-style: none;
  padding: 0;
  margin: 0;
  width: 100%;
  border: 1px solid #ddd; /* Borde elegante */
  border-radius: 5px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Sombra suave */
}

.suggestions-list li {
  padding: 10px;
  cursor: pointer;
  font-family: 'Arial', sans-serif; /* Fuente elegante */
  font-size: 14px; /* Tamaño de fuente */
  color: #333; /* Color del texto */
  border-bottom: 1px solid #eee; /* Línea divisoria */
  transition: background 0.2s, color 0.2s; /* Efecto suave al pasar el ratón */
}

.suggestions-list li:last-child {
  border-bottom: none; /* Sin línea divisoria para el último elemento */
}

.suggestions-list li:hover {
  background: #007bff; /* Fondo azul al pasar el ratón */
  color: #fff; /* Texto blanco */
}
</style>

   <div class="row domicilio">
     <div class="col-lg-2">
       <?= $form->field($domicilio, 'direccion')->textInput([
           'id' => "domicilio-direccion{$key}",
           'name' => "Domicilios[$key][direccion]",
           'class' => 'form-control',
           'style' => 'width:100%; text-transform:uppercase;',
           'placeholder' => 'Escribe una dirección...',
           'oninput' => "autocompleteAddress(this, '{$key}')"
       ])->label(false); ?>

       <ul id="suggestions-<?= $key ?>" class="suggestions-list" style="position: absolute; z-index: 1000; background: #fff; list-style: none; padding: 0; width: 100%;"></ul>


     </div>
     <div class="col-lg-1">
       <?= $form->field($domicilio, 'id_tipodom')->dropDownList(
         $domicilio->getTipodoms(),
       ['id' => "domicilio-id_tipo{$key}",
           'name' => "Domicilios[$key][id_tipodom]",
          ]
         )->label(false) ;?>
     </div>
       <div class="col-lg-2">
         <?=$form->field($domicilio, 'id_provincia')->dropDownList(
              $domicilio->getProvincias(),
              [
                  'id' => "domicilio-provincia{$key}",
                  'name' => "Domicilios[$key][id_provincia]",
                  'value'=> 22, //valor por default
                  'prompt'=>'Por favor elija una',
                  'onchange'=>'$.get( "'.Url::toRoute('localidad/arraylocalidades').'", { id: $(this).val() } )
                              .done(function( data ) {
                          $( "#'.Html::getInputId($domicilio, "localidad{$key}").'" ).html( data );
                        }
                    );'
              ]
          )->label(false);?>

      </div>
   		<div class="col-lg-2">
        <?php echo $form->field($domicilio, 'id_localidad')->dropDownList(
          ($domicilio->isNewRecord)?$domicilio->getLocalidades(22) : $domicilio->getLocalidades($domicilio->provincia->id),
            [
               'id' => "domicilio-localidad{$key}",
               'name' => "Domicilios[$key][id_localidad]",
               'value'=> 2845, //valor por default
                'prompt'=>'Por favor elija uno',
                'onchange'=>'$.get( "'.Url::toRoute('barrio/arraybarrios').'", { id: $(this).val() } )
                                    .done(function( data ) {
                                      $( "#'.Html::getInputId($domicilio, "barrio{$key}").'" ).html( data );
                              }
                          );'
            ]
        )->label(false); ?>

		</div>
    <div class="col-lg-1">
    <?  if ($domicilio->isNewRecord){
          echo $form->field($domicilio, 'id_barrio')->dropDownList(
            $domicilio->getBarrios(2845) ,
            ['prompt'=>'Por favor elija una',
          'id' => "domicilio-barrio{$key}",
          'value'=> 76, //valor por default
          'name' => "Domicilios[$key][id_barrio]"
          ])->label(false);

    }
      else
      {
          $barrios = ArrayHelper::map(Barrio::find()->orderBy(['nombre' => SORT_ASC])->where(['id_localidad' =>$domicilio->id_localidad])->all(), 'id', 'nombre');
          echo $form->field($domicilio, 'id_barrio')->dropDownList($barrios,
          [ 'id' => "domicilio-barrio{$key}",
            'name' => "Domicilios[$key][id_barrio]"])->label(false);
      }

      ?>


		</div>
    <div class="col-lg-1">
        <?=$form->field($domicilio, 'principal')->checkBox([
        'id' => "domicilio-principal{$key}",
        'name' => "Domicilios[$key][principal]",
          'class' =>'form-control',
          'label' =>false,
           // 'checked' => '1',
          // 'value' => '1',
          'style' => 'width: 50px; height: 30px;', // Added styles for size
          'title' =>'Solo debe tener un domicilio principal'
      ]); ?>
    </div>
    <div class="col-lg-2">
    <?=$form->field($domicilio, 'fechabaja')
      ->widget(DateControl::classname(), [
        'options' => ['placeholder' => 'Debe agregar una fecha',
                ],
        'type'=>DateControl::FORMAT_DATE,
        'displayFormat' => 'php:d/m/Y',
        'saveFormat' => 'php:Y-m-d',
        'saveOptions' => [
          'name' => "Domicilios[$key][fechabaja]",
          'id' => "domicilio-fechabaja{$key}",
              ],
          ])->label(false);
  ?>
    </div>

    	<div class="col-lg-1">
         <?= Html::a('<i class="glyphicon glyphicon-trash" ></i> ' ,($domicilio->isNewRecord)?'javascript:void(0);':'', [
           'class' => 'paciente-eliminar-domicilio-boton btn btn-danger',
           'title'=>($domicilio->isNewRecord)?'Eliminar':'NO SE PUEDE ELIMINAR',
           'disabled'=> ($domicilio->isNewRecord)?false:true
            ]) ?>
    	</div>
    </div>

    <script>
    function autocompleteAddress(input, key) {
    const query = input.value;
    const suggestionsId = "suggestions-" + key;

    // Evitar consultas si el campo está vacío
    if (query.length < 3) {
      document.getElementById(suggestionsId).innerHTML = '';
      return;
    }

    // Llamada a Photon API (o cualquier servicio)
    fetch(`https://photon.komoot.io/api/?q=${encodeURIComponent(query + ' ' + "Viedma")}`)
      .then(response => response.json())
      .then(data => {
        if (data && data.features && data.features.length > 0) {
          // Filtrar los resultados para que solo muestren los que son de Argentina y de la provincia de Río Negro
          const suggestions = data.features
            .filter(feature => feature.properties.state === "Río Negro") // Filtrar por país y provincia
            .map(feature => feature.properties);
          displaySuggestions(suggestions, suggestionsId, input, key);
        } else {
          // Si no hay resultados, se puede mostrar un mensaje informativo
          displaySuggestions([], suggestionsId, input, key);
        }
      })
      .catch(error => console.error("Error:", error));
  }

  function displaySuggestions(suggestions, suggestionsId, input, key) {
    const suggestionsList = document.getElementById(suggestionsId);
    suggestionsList.innerHTML = ''; // Limpiar sugerencias previas

    if (suggestions.length === 0) {
      // Mensaje cuando no hay sugerencias
      const li = document.createElement('li');
      li.textContent = 'No se encontraron resultados';
      li.style.padding = '5px';
      suggestionsList.appendChild(li);
    } else {
      suggestions.forEach(suggestion => {
        const li = document.createElement('li');
        li.textContent = suggestion.street + ' ' + suggestion.housenumber + ', ' + suggestion.district + ', ' + suggestion.city;
        li.style.padding = '5px';
        li.style.cursor = 'pointer';
        li.onclick = () => {
          input.value = suggestion.street + ' ' + suggestion.housenumber;
          suggestionsList.innerHTML = ''; // Limpiar lista

          // Aquí seleccionamos el barrio en el dropdown que coincide con el barrio de la sugerencia
          const barrioDropdown = document.getElementById("domicilio-barrio" + key);
          if (barrioDropdown) {
            const barrios = Array.from(barrioDropdown.options);
            const matchingOption = findBestMatch(barrios, suggestion.district);

            if (matchingOption) {
              barrioDropdown.value = matchingOption.value; // Seleccionar la opción correspondiente
            }
          }
        };
        suggestionsList.appendChild(li);
      });
    }
  }

  function findBestMatch(options, district) {
    district = normalizeString(district); // Normalizar texto del barrio de la API
    let bestMatch = null;
    let bestScore = 0;

    options.forEach(option => {
      const optionText = normalizeString(option.text);
      const score = calculateSimilarity(optionText, district);

      if (score > bestScore) {
        bestScore = score;
        bestMatch = option;
      }
    });

    return bestScore >= 0.2 ? bestMatch : null; // Umbral de similitud
  }

  // Normalizar cadenas para hacerlas comparables (remover acentos, pasar a minúsculas)
  function normalizeString(str) {
    return str
      .normalize("NFD") // Descomponer caracteres Unicode
      .replace(/[\u0300-\u036f]/g, "") // Eliminar diacríticos (acentos)
      .toLowerCase();
  }

  // Calcular similitud entre dos cadenas (coeficiente de Jaccard)
  function calculateSimilarity(str1, str2) {
    const set1 = new Set(str1.split(" "));
    const set2 = new Set(str2.split(" "));

    const intersection = [...set1].filter(x => set2.has(x));
    const union = new Set([...set1, ...set2]);

    return intersection.length / union.size; // Similitud Jaccard
  }

    </script>
