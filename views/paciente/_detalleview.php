<?
use yii\widgets\DetailView;
?>
<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'apellido',
        'nombre',
        'tipodoc.documento',
        'numdocumento',
        'hc',
        'sexo',
        [
        'value'=> $model->nacionalidad->gentilicio,
        'label'=> 'Nacionalidad',
       ],
       'fechanacimiento',
        // 'email',
        [
            'label' => 'Domicilio',
              'format'    => 'html',
              'value'     => call_user_func(function($model)
              {
                  $items = "";
                  $num=1;
                  foreach ($model->domicilios as $domicilio) {
                      $items .="<u><b>DOMICILIO</b> </u> ".$num."<br>";
                      $items .="<b>Dirección:</b>". $domicilio->direccion."<br>
                              <b>Tipo</b>: ".$domicilio->tipodom->descripcion."<br>
                              <b>Provincia</b>: ".$domicilio->provincia->nombre."<br>
                              <b>Localidad</b>: ".$domicilio->localidad->nombre."<br>
                              <b>Barrio</b>: ".($domicilio->barrio==null?'No definido':$domicilio->barrio->nombre)."<br>
                              <b>Principal</b>: ".($domicilio->principal?"SI":"NO")."<br>";

                        $num ++;

                  }
                  return $items;
              }, $model)
        ],
        [
            'label' => 'Telefono',
              'format'    => 'html',
              'value'     => call_user_func(function($model)
              {
                  $items = "";
                  $num=1;
                  foreach ($model->telefonos as $telefono) {
                      $items .="<u><b>TELEFONO</b> </u> ".$num."<br>";
                      $items .="<b>Numero:</b> ". $telefono->numero."<br>
                              <b>Tipo</b>: ".$telefono->tipotel->descripcion."<br>";
                        $num ++;

                  }
                  return $items;
              }, $model)
        ],

        [
              'label' => 'Obra social',
              'format'    => 'html',
              'value'     => call_user_func(function($model)
              {
                  $items = "";
                  $num=1;
                  foreach ($model->pacienteObrasocials as $carnet) {
                      $items .="<u><b>OBRA SOCIAL</b> </u> ".$num."<br>";
                      $items .= "<b>Denominación:</b> ".$carnet->obrasocial->denominacion."<br>
                      <b>Nº Afiliado:</b> ". $carnet->nroafiliado."<br>";
                      $num ++;

                  }
                  return $items;
              }, $model)
       ],
       [
           'label' => 'Correo',
             'format'    => 'html',
             'value'     => call_user_func(function($model)
             {
                 $items = "";
                 $num=1;
                 foreach ($model->correos as $correo) {
                     $items .="<u><b>CORREO</b> </u> ".$num."<br>";
                     $items .="<b>Dirección:</b> ". $correo->direccion."<br>";                           $num ++;

                 }
                 return $items;
             }, $model)
       ],

    ],
]) ?>
