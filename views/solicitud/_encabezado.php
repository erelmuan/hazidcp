<?
use yii\helpers\Html;
?>
    <style>
        .header-container {
            background-color: #eef4f9;
            padding: 10px;
            margin-bottom: 10px;
            padding-bottom: 1px;
        }

        .table-custom th {
            background-color:  #2c3e50  ;
            color: white;
            text-align: center;
            padding: 4px;
        }
        .table-custom td {
            color: black;
            padding: 4px;
        }
        .table-custom tbody tr:nth-child(odd) td {
            background-color: white;
        }
        .table-custom tbody tr:nth-child(even) td {
            background-color: white;
        }
    </style>

    <div class="x_content" style="display: block;">


    <div class="header-container">
        <div class="container">
            <table class="table table-bordered table-custom">
                <thead>
                    <tr>
                        <th colspan="4">Encabezado de la solicitud</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Servicio:</strong> <?=$model_solicitud->servicio->nombre ?></td>
                        <td><strong>Procedencia:</strong> <?=$model_solicitud->procedencia->nombre ?></td>
                        <td><strong>Fecha de la solicitud:</strong> <?= Yii::$app->formatter->asDate($model_solicitud->fechasolicitud, 'php:d/m/Y') ?></td>
                        <td><strong>Médico solicitante:</strong> <?=$model_solicitud->profesional->apellido .', '.$model_solicitud->profesional->nombre ?></td>
                    </tr>
                    <tr>
                        <td><strong>Especialidad:</strong> <?=$model_solicitud->profesional->especialidad->nombre ?></td>
                        <td><strong>Paciente:</strong> <?=Html::a('<i class="glyphicon glyphicon-eye-open"></i>'.' '.$model_solicitud->paciente->apellido .', '.$model_solicitud->paciente->nombre, ['paciente/view' ,'id'=> $model_solicitud->id_paciente],
                        ['role'=>'modal-remote','title'=> 'Ver paciente']); ?></td>
                        <td><strong>Diag. Solicitud:</strong>
                          <? $items = "";
                          if ($model_solicitud->solicitudDiagnostico && $model_solicitud->solicitudDiagnostico->diagnostico) {

                              $items .= $model_solicitud->solicitudDiagnostico->diagnostico->descripcion."<br>
                                      <b>codigo</b>: ".$model_solicitud->solicitudDiagnostico->diagnostico->codigo."&nbsp;&nbsp;
                                        <b>Principal</b>: ".($model_solicitud->solicitudDiagnostico->principal?"SI":"NO")."<br>";
                                }

                          echo $items; ?>

                        </td>
                        <td><strong>Diag. Int:</strong>
                          <?php
                      $items = "";
                      if ($model_solicitud->solicitudDiagnosticoInternacion && $model_solicitud->solicitudDiagnosticoInternacion->diagnostico) {
                          $items .= $model_solicitud->solicitudDiagnosticoInternacion->diagnostico->descripcion."<br>
                                    <b>codigo</b>: ".$model_solicitud->solicitudDiagnosticoInternacion->diagnostico->codigo."&nbsp;&nbsp;
                                    <b>Principal</b>: ".($model_solicitud->solicitudDiagnosticoInternacion->principal ? "SI" : "NO")."<br>";
                      }
                      echo $items;
                      ?>

                        </td>

                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
