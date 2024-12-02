<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use johnitvn\ajaxcrud\CrudAsset;
use kartik\widgets\FileInput;
use yii\helpers\Url;

$this->title = 'Perfil';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div id="w0" class="x_panel">
  <h2><i class="fa fa-table"></i> PERFIL</h2>
  <div class="usuario-misdatos">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
      <li class="active"><a href="#general" role="tab" data-toggle="tab">Datos del usuario</a></li>
      <li><a href="#photo" role="tab" data-toggle="tab">Subir o actualizar foto</a></li>
    </ul>
    <div class="perfil-form">
      <?php $form = ActiveForm::begin(); ?>

      <div class="tab-content">
        <div class="tab-pane active vertical-pad" id="general">
          <div class="row">
            <div class="col-md-7 col-sm-12">
              <div class="x_panel">
                <?= $form->field($model, 'usuario')->textInput(['maxlength' => true, 'readonly' => true, 'class' => 'form-control']); ?>
                <?= $form->field($model, 'nombre')->textInput(['maxlength' => true, 'class' => 'form-control']); ?>
                <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'class' => 'form-control']); ?>
                <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true, 'class' => 'form-control']); ?>
                <?= $form->field($model, 'contrasenia')->hiddenInput()->label(false); ?>
                <?= $form->field($model, 'id_pantalla')->hiddenInput()->label(false); ?>
              </div>
            </div>
            <div class="col-md-4 col-sm-12 text-center">
              <div class="x_panel">
                <img src="<?= Url::base(true) ?>/uploads/avatar/sqr_<?= Yii::$app->user->identity->imagen ?>" class="img-circle profile_img img-responsive" alt="...">
              </div>
            </div>
          </div>
          <div class="form-group text-center">
            <?= Html::submitButton('Aceptar cambios', ['class' => 'btn btn-primary', 'name' => 'Aceptar', 'style' => 'min-width: 150px;']) ?>
            <?= Html::a('<i class="glyphicon glyphicon-edit"> Cambiar contraseña</i>', ['usuario/cambiarcontrasenia'], [
              'role' => 'modal-remote',
              'title' => 'Cambio de contraseña',
              'class' => 'btn btn-primary',
              'style' => 'min-width: 200px; margin-left: 15px;',
            ]); ?>
          </div>
        </div>

        <div class="tab-pane vertical-pad" id="photo">
          <?= $form->field($model, 'imagen')->widget(FileInput::classname(), [
            'options' => ['accept' => 'image/*'],
            'language' => 'es',
            'pluginOptions' => ['allowedFileExtensions' => ['jpg', 'gif', 'png']],
          ]) ?>
          <?= $form->field($model, 'imagen')->hiddenInput(['value' => $model->imagen])->label(false); ?>
        </div>
      </div>

      <?php ActiveForm::end(); ?>
    </div>
  </div>
</div>


<?php Modal::begin([
    "id" => "ajaxCrudModal",
    "footer" => "", // always need it for jquery plugin
]) ?>
<?php Modal::end(); ?>
