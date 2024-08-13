<style>
  .x_title h2 {
      margin: 5px 0 6px;
      float: left;
      display: block;
      text-overflow: ellipsis;
      overflow: hidden;
      white-space: nowrap;
  }
  .x_title {
    border-bottom: 2px solid #E6E9ED;
    padding: 0px;
    margin-bottom: 10px;
    height:45;
}

</style>
<?php
use kartik\icons\Icon;
use yii\helpers\Html;

Icon::map($this, Icon::WHHG);

// Maps the Elusive icon font framework/* @var $this yii\web\View */

$this->title = 'Extras';

  use derekisbusy\panel\PanelWidget;
  ?>
  <div id="w0" class="x_panel">
  <div class="x_title"><h2><i class="fa fa-table"></i> TABLAS EXTRAS  </h2>
    <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Atrás', ['/site'], ['class'=>'btn btn-danger grid-button']) ?></div>
    </div>
  </div>

  <div class="body-content">


  <div class="row">
    <div class="row top_tiles">
      <a href=<?=Yii::$app->homeUrl."procedencia"; ?>>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats azul">
            <div class="icon"><i class="fa fa-location-arrow"></i>
            </div>
            <div class="count"><?=$cantidadProcedencia ?></div>
            <h3>PROCEDENCIAS</h3>
            <p>AMB del lugar de origen de las muestras.</p>
        </div>
      </div>
      </a>

      <a href=<?=Yii::$app->homeUrl."provincia"; ?>>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats azul">
          <div class="icon"><i class="fa fa-map-marker"></i>
          </div>
          <div class="count"><?=$cantidadProvincia ?></div>

          <h3>PROVINCIAS</h3>
          <p>ABM de las provincias de Argentina.</p>
        </div>
      </div>
    </a>
    <a href=<?=Yii::$app->homeUrl."localidad"; ?>>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <div class="tile-stats azul">
          <div class="icon"><i class="fa fa-map-marker"></i>

          </div>
          <div class="count"><?=$cantidadLocalidad ?></div>
          <h3>LOCALIDADES</h3>
          <p>ABM de las localidades de la Argentina.</p>


      </div>
    </div>
    </a>
    <a href=<?=Yii::$app->homeUrl."barrio"; ?>>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <div class="tile-stats azul">
          <div class="icon"><i class="fa fa-map-marker"></i>
          </div>
          <div class="count"><?=$cantidadBarrios ?></div>
          <h3>BARRIOS</h3>
          <p>Alta-Baja-Modificacion.</p>
      </div>
    </div>
    </a>

    <a href=<?=Yii::$app->homeUrl."obrasocial"; ?>>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <div class="tile-stats rojo">
          <div class="icon"><i class="fa fa-book"></i>
          </div>
          <div class="count"><?=$cantidadObrasocial ?></div>
          <h3>OBRAS SOCIALES</h3>
          <p>ABM de las obras sociales.</p>


      </div>
    </div>
    </a>
    <a href=<?=Yii::$app->homeUrl."tipodoc"; ?>>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <div class="tile-stats rojo">
          <div class="icon"><i class="fa fa-book"></i>
          </div>
          <div class="count"><?=$cantidadTipoDoc ?></div>
          <h3>TIPO DE DOC.</h3>
          <p>ABM de los tipos de doc.</p>
      </div>
    </div>
    </a>
    <a href=<?=Yii::$app->homeUrl."tipodom"; ?>>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <div class="tile-stats rojo">
          <div class="icon"><i class="fas fa-home"></i>
          </div>
          <div class="count"><?=$cantidadTipoDomicilios?></div>
          <h3> TIPO DE DOMICILIOS.</h3>
          <p>AMB tipo de domicilios.</p>
      </div>
    </div>
    </a>
    <a href=<?=Yii::$app->homeUrl."tipotel"; ?>>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <div class="tile-stats rojo">
          <div class="icon"><i class="fas fa-phone"></i>
          </div>
          <div class="count"><?=$cantidadTipoTelefonos?></div>
          <h3> TIPO DE TELEFONOS</h3>
          <p>Tipo telefonos.</p>
      </div>
    </div>
    </a>
    <a href=<?=Yii::$app->homeUrl."nacionalidad"; ?>>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <div class="tile-stats rojo">
          <div class="icon"><i class="fa fa-flag"></i>
          </div>
          <div class="count"><?=$cantidadNacionalidad ?></div>
          <h3>NACIONALIDADES</h3>
          <p>ABM de las nacionalidades.</p>
      </div>
    </div>
    </a>
    <a href=<?=Yii::$app->homeUrl."estado"; ?>>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <div class="tile-stats rojo">
          <div class="icon"><i class="fa fa-dashboard"></i>
          </div>
          <div class="count"><?=$cantidadEstado ?></div>
          <h3>ESTADOS</h3>
          <p>Estados de los estudios y solicitudes.</p>
      </div>
    </div>
    </a>
  </a>
    <a href=<?=Yii::$app->homeUrl."servicio"; ?>>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <div class="tile-stats rojo">
          <div class="icon"><i class="fa fa-exchange"></i>
          </div>
          <div class="count"><?=$cantidadServicios ?></div>
          <h3>SERVICIOS</h3>
          <p>ABM servicios.</p>
      </div>
    </div>
    </a>
    <a href=<?=Yii::$app->homeUrl."empresa"; ?>>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <div class="tile-stats rojo">
          <div class="icon"><i class="fas fa-university"></i>
          </div>
          <div class="count"><?=$cantidadEmpresas?></div>
          <h3> EMPRESAS TEL.</h3>
          <p>SABM empresas telefonicas.</p>
      </div>
    </div>
    </a>
    <a href=<?=Yii::$app->homeUrl."solicitud/anulado"; ?>>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <div class="tile-stats verde">
          <div class="icon"><i class="fas fa-times-circle"></i>
          </div>
          <div class="count"><?=$cantidadSolicitudesAnuladas?></div>
          <h3> SOLICITUDES ANUL.</h3>
          <p>Solicitudes baja logicas.</p>
      </div>
    </div>
    </a>
    <a href=<?=Yii::$app->homeUrl."tipoconsulta"; ?>>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <div class="tile-stats verde">
          <div class="icon"><i class="fas fa-question-circle"></i>
          </div>
          <div class="count"><?=$cantidadTipoConsultas?></div>
          <h3> TIPO DE CONSULTAS</h3>
          <p>AMB Tipo consultas.</p>
      </div>
    </div>
    </a>
      <a href=<?=Yii::$app->homeUrl."plantillareunionfamiliar"; ?>>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats verde">
            <div class="icon"><i class="icon-pastealt"></i>
            </div>
            <div class="count"><?=$cantidadplantillareunionfamiliares?></div>
            <h3> PLANTILLA R. FLIAR</h3>
            <p>ABM Plantillas.</p>
        </div>
      </div>
      </a>
        <a href=<?=Yii::$app->homeUrl."tipoegreso"; ?>>
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
          <div class="tile-stats verde">
              <div class="icon"><i class="fas fa-sign-in"></i>
              </div>
              <div class="count"><?=$cantidadTipoEgresos?></div>
              <h3> TIPO DE EGRESOS</h3>
              <p>ABM tipo de egresos.</p>
          </div>
        </div>
        </a>
        <a href=<?=Yii::$app->homeUrl."tipoingreso"; ?>>
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
          <div class="tile-stats verde">
              <div class="icon"><i class="fas fa-sign-out"></i>
              </div>
              <div class="count"><?=$cantidadTipoIngresos?></div>
              <h3> TIPO DE INGRESOS</h3>
              <p>ABM tipo de ingresos.</p>
          </div>
        </div>
        </a>
        <a href=<?=Yii::$app->homeUrl."tipointernacion"; ?>>
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
          <div class="tile-stats verde">
              <div class="icon"><i class="fas fa-medkit"></i>
              </div>
              <div class="count"><?=$cantidadTipoInternaciones?></div>
              <h3> TIPO DE INTER.</h3>
              <p>ABM internaciones.</p>
          </div>
        </div>
        </a>
        <a href=<?=Yii::$app->homeUrl."diagnostico"; ?>>
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
          <div class="tile-stats verde">
              <div class="icon"><i class="fas fa-file-text-o"></i>
              </div>
              <div class="count"><?=$cantidadDiagnosticos?></div>
              <h3> DIAGNOSTICOS.</h3>
              <p>ABM diagnosticos.</p>
          </div>
        </div>
        </a>
        <a href=<?=Yii::$app->homeUrl."especialidad"; ?>>
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
          <div class="tile-stats verde">
              <div class="icon"><i class="fa fa-mortar-board"></i>
              </div>
              <div class="count"><?=$cantidadEspecialidad ?></div>
              <h3>ESPECIALIDADES</h3>
              <p>Alta-Baja-Modificacion.</p>
          </div>
        </div>
        </a>
        <a href=<?=Yii::$app->homeUrl."detalle"; ?>>
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
          <div class="tile-stats verde">
            <div class="icon"><i class="fa fa-map-marker"></i>
            </div>
            <div class="count"><?=$cantidadProvincia ?></div>

            <h3>DETALLES</h3>
            <p>ABM de las detalles tipo de egreso.</p>
          </div>
        </div>
      </a>

    </div>

  </div>

</div>

</div>
