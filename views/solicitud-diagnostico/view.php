<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SolicitudDiagnostico */
?>
<div class="solicitud-diagnostico-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_diagnostico',
            'id_solicitud',
            'principal:boolean',
            'registro_usuario',
            'registro_tiempo',
            'diag_internacion:boolean',
        ],
    ]) ?>

</div>
