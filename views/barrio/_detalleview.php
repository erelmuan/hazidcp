<?
use yii\widgets\DetailView;
?>
<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        [
          'value'=> $model->paciente->apellido .' '.$model->paciente->nombre,
          'label'=> 'Paciente',
        ],
        'motivo',
        [
          'value'=> $model->tiporeg->descripcion,
          'label'=> 'Tipo de registro',
        ],
        [
          'value'=> ($model->organismo)?$model->organismo->nombre:'(No definido)',
          'label'=> 'Organismo',
        ],
        [
          'value'=> ($model->area)?$model->area->nombre:'(No definido)',
          'label'=> 'Area',
        ],
        [
        'label'=> 'Fecha',
        'value'=> $model->fecha ,
        'format' => ['date', 'd/M/Y'],
          ],
        'numero_nota',
        [
          'value'=> $model->usuario->nombre,
          'label'=> 'Usuario',
        ],
    ],
]) ?>
