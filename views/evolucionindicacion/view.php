<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Evolucionindicacion */
?>
<div class="evolucionindicacion-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_internacion',
            'observacion:ntext',
            'nombreusuario',
            'especialidad',
            'tiporegistro',
            'enfermeria:boolean',
            ['value'=> date("d/m/Y H:i:s",strtotime($model->fechahora)),
              'label'=> 'Fecha y hora',
           ],
        ],
    ]) ?>

</div>
