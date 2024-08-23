<?
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;

CrudAsset::register($this);

?>

<div class="x_content">
    <div class="modal fade bs-profesionalAC-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-body">
            <div class="profesionalAC-index">
                <div id="ajaxCrudDatatable">
                  <?=GridView::widget([
                      'id'=>'crud-profesionalAC',
                      'dataProvider' => $modelosDat['dataProviderPAC'],
                      'filterModel' => $modelosDat['searchModelPAC'],
                      'pjax'=>true,
                      'columns' => require(__DIR__.'/_columnsProfesional.php'),
                      'toolbar'=> [

                      ],
                      //Adaptacion para moviles
                      'responsiveWrap' => false,
                      'panel' => [
                          'type' => 'primary',
                          'heading'=> false,
                      ]

                  ])?>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="button"  onclick='agregarFormularioMed("acargo");' class="btn btn-primary">Agregar al formulario</button>
            </div>
      </div>
    </div>
  </div>
</div>
</div>



<div class="x_content">
    <div class="modal fade bs-profesional-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-body">
            <div class="profesional-index">
                <div id="ajaxCrudDatatable">
                  <?=GridView::widget([
                      'id'=>'crud-profesional',
                      'dataProvider' => $modelosDat['dataProviderProf'],
                      'filterModel' => $modelosDat['searchModelProf'],
                      'pjax'=>true,
                      'columns' => require(__DIR__.'/_columnsProfesional.php'),
                      'toolbar'=> [

                      ],
                      //Adaptacion para moviles
                      'responsiveWrap' => false,
                      'panel' => [
                          'type' => 'primary',
                          'heading'=> false,
                      ]

                  ])?>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="button"  onclick='agregarFormularioMed("solicitante");' class="btn btn-primary">Agregar al formulario</button>
            </div>
      </div>
    </div>
  </div>
</div>
</div>
<div class="x_content">
  <div class="modal fade bs-diagnostico-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-body">
           <span id="modal-parametro">.</span>
           <div class="diagnostico-index">
              <div id="ajaxCrudDatatable">
                <?=GridView::widget([
                    'id'=>'crud-diagnostico',
                    'dataProvider' => $modelosDat['dataProviderDiag'],
                    'filterModel' => $modelosDat['searchModelDiag'],
                    'pjax'=>true,
                    'columns' => require(__DIR__.'/_columnsDiagnostico.php'),
                    'toolbar'=> [

                    ],
                    //Adaptacion para moviles
                    'responsiveWrap' => false,
                    'panel' => [
                        'type' => 'primary',
                        'heading'=> false,
                    ]
                ])?>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="button" onclick="agregarFormularioDiag()" class="btn btn-primary">Agregar al formulario</button>  </div>
    </div>
  </div>
</div>
</div>
</div>
