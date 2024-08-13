<?
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;

CrudAsset::register($this);

?>

<?

    $columnsPlantilla=
        [
          [
              'class' => '\kartik\grid\RadioColumn',
              'width' => '20px',
          ],
          [
              'class'=>'\kartik\grid\DataColumn',
              'attribute'=>'codigo',
          ],
          [
              'class'=>'\kartik\grid\DataColumn',
              'attribute'=>'descripcion',
          ],

        ];

?>



<div class="x_content">
    <div id="modal-plantilla" class="modal fade bs-plantilla-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="plantilla-index">
                        <div id="ajaxCrudDatatable">
                            <?=GridView::widget([
                            'id'=>'crud-plantilla',
                            'dataProvider' => $provider,
                            'filterModel' => $search,
                            // 'filterOnFocusOut'=>true,
                            'pjax'=>true,
                            'columns' => $columnsPlantilla,
                            'toolbar'=> [
                            ],
                            //Adaptacion para moviles
                            'responsiveWrap' => false,
                            'panel' => [
                                'type' => 'primary',
                                'heading'=> false,

                            ]
                        ])
                        ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default"  onclick="cerrarSoloSegundoModal()">Cerrar</button>
                       <button type="button" onclick='agregarFormulario();' class="btn btn-primary">Agregar al
                            formulario</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
