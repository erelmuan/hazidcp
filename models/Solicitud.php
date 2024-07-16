<?php

namespace app\models;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "solicitud".
 *
 * @property int $id
 * @property int $id_paciente
 * @property int $id_procedencia
 * @property int $id_profesional
 * @property int $id_materialsolicitud
 * @property string $fecharealizacion
 * @property string $fechasolicitud
 * @property string $observacion
 * @property int $id_estado
 * @property int $id_servicio
 * @property Estado $estado
 * @property Servicio $servicio
 * @property Profesional $profesional
 * @property Paciente $paciente
 * @property Materialsolicitud $materialsolicitud
 * @property Procedencia $procedencia
 * @property Servicio $servicio
 * @property Reunionfamiliar[] $reunionfamiliars
 * @property SolicitudDiagnostico[] $solicitudDiagnosticos
 * @property Internacion $internacion
 * @property string $direccion
 * @property string $barrio
 */
 use app\components\behaviors\AuditoriaBehaviors;

class Solicitud extends \yii\db\ActiveRecord
{
  public $num_documento;
  public $edad;

  public function behaviors()
  {

    return [

           'AuditoriaBehaviors'=>[
                  'class'=>AuditoriaBehaviors::className(),
                ],
      ];
 }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'solicitud';
    }
    public static function modelo()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
          [['id_paciente'], 'required',  'message' => 'El campo paciente no puede estar vacío.'],
          [['id_profesional'], 'required',  'message' => 'El campo profesional no puede estar vacío.'],
          [['id_paciente', 'id_procedencia', 'id_profesional',  'fechasolicitud', 'id_servicio', 'id_estado'], 'required'],
          [['id_paciente', 'id_procedencia', 'id_profesional', 'id_servicio', 'id_estado' ,'num_documento'], 'integer'],
          [['observacion','direccion', 'barrio'], 'string'],
          [['fechasolicitud'], 'safe'],
          [['fechasolicitud'], 'validateFechas'],
          [['id_estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estado::className(), 'targetAttribute' => ['id_estado' => 'id']],
          [['id_profesional'], 'exist', 'skipOnError' => true, 'targetClass' => Profesional::className(), 'targetAttribute' => ['id_profesional' => 'id']],
          [['id_paciente'], 'exist', 'skipOnError' => true, 'targetClass' => Paciente::className(), 'targetAttribute' => ['id_paciente' => 'id']],
          [['id_procedencia'], 'exist', 'skipOnError' => true, 'targetClass' => Procedencia::className(), 'targetAttribute' => ['id_procedencia' => 'id']],
          [['id_servicio'], 'exist', 'skipOnError' => true, 'targetClass' => Servicio::className(), 'targetAttribute' => ['id_servicio' => 'id']],
          ];
    }

  public function validateFechas($attribute, $params){
      $internacion = Internacion::findOne(['id_solicitud' => $this->id]);
        if ($internacion) {
          $fechaSolicitudTimestamp = strtotime($this->fechasolicitud);
          $fechaInternacionTimestamp = strtotime($internacion->fechahoraingreso);

          if ($fechaInternacionTimestamp < $fechaSolicitudTimestamp) {

              $this->addError($attribute, 'La fecha de solicitud no puede ser mayor que la fecha de internación.');

          }

      }
   }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_paciente' => 'Id Paciente',
            'id_procedencia' => 'Procedencia',
            'id_profesional' => 'Id Profesional',
            'id_materialsolicitud' => 'Id materialsolicitud',
            'fechasolicitud' => 'Fecha de soliicitud',
            'observacion' => 'Observacion',
            'id_servicio' => 'Servicio',
            'id_estado' => 'Estado de la solicitud',
            'direccion' => 'Direccion',
            'barrio' => 'Barrio',
        ];
    }
    public function attributeColumns()
    {

        return [
            [
                'class'=>'\kartik\grid\DataColumn',
                'attribute'=>'id',
            ],
            [
              //nombre
              'class'=>'\kartik\grid\DataColumn',
              'attribute'=>'fechasolicitud',
              'label'=> 'Fecha de solicitud',
              'value'=>'fechasolicitud',
              'format' => ['date', 'd/M/Y'],
              'filterInputOptions' => [
                  'id' => 'fecha1',
                  'class' => 'form-control',
                  'autoclose'=>true,
                  'format' => 'dd/mm/yyyy',
                  'startView' => 'year',
                  'placeholder' => 'd/m/aaaa'

              ]
            ],
            [
                'class'=>'\kartik\grid\DataColumn',
                'attribute'=>'paciente',
                'width' => '170px',
                'value' => 'pacienteurl',
                 'filterInputOptions' => ['class' => 'form-control','placeholder' => 'Ingrese DNI o apellido'],
                 'format' => 'raw',
                 'contentOptions' => ['style' => 'white-space: nowrap;'],
            ],

          [
              'class'=>'\kartik\grid\DataColumn',
              'attribute'=>'profesional',
              'label'=>'Profesional solicitante',
              'width' => '170px',
              'value' => 'profesionalurl',
               'filterInputOptions' => ['class' => 'form-control','placeholder' => 'Ingrese Matricula o apellido'],
               'format' => 'raw',
               'contentOptions' => ['style' => 'white-space: nowrap;'],
          ],

          [
              'class'=>'\kartik\grid\DataColumn',
              'attribute'=>'procedencia',
              'label'=> 'Procedencia',
              'value'=>'procedencia.nombre'
          ],

         [
              'class'=>'\kartik\grid\DataColumn',
              'attribute'=>'servicio',
              'label'=> 'Servicio',
              'value'=>'servicio.nombre',
          ],

          [
            'class'=>'\kartik\grid\DataColumn',
            'attribute' => 'estado',
            'label' => 'Estado de la solicitud',
            'value' => 'estado.descripcion',

          ],

          [
              'class'=>'\kartik\grid\DataColumn',
              'attribute'=>'observacion',
          ],
          [
              'class'=>'\kartik\grid\DataColumn',
              'attribute'=>'direccion',
          ],
          [
              'class'=>'\kartik\grid\DataColumn',
              'attribute'=>'barrio',
          ],

        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstado()
    {
        return $this->hasOne(Estado::className(), ['id' => 'id_estado']);
    }



    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfesional()
    {
        return $this->hasOne(Profesional::className(), ['id' => 'id_profesional']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaciente()
    {
        return $this->hasOne(Paciente::className(), ['id' => 'id_paciente']);
    }



    public function idEstudio(){
        $estudio=Estudio::find()->where(['modelo'=>$this->modelo()])->all();
        return $estudio[0]->id;

    }


    //la fecha tiene que estar en formato d-m-y
    function calcular_edad(){
        list($ano,$mes,$dia) = explode("-",$this->paciente->fechanacimiento);
        list($anoR,$mesR,$diaR) = explode("-",$this->fechasolicitud);
        $ano_diferencia  = $anoR - $ano;
        $mes_diferencia = $mesR - $mes;
        $dia_diferencia   = $diaR - $dia;
        if ( $mes_diferencia < 0)
        {
          $ano_diferencia--;
        }
        elseif ( $mes_diferencia == 0){
          if ( $dia_diferencia < 0)
              $ano_diferencia--;
          }
          return $ano_diferencia;
      }

     public function getPacienteurl(){
         return Html::a( $this->paciente->apellido.', '. $this->paciente->nombre ,['paciente/view',"id"=> $this->paciente->id]
           ,[    'class' => 'text-success','role'=>'modal-remote','title'=>'Datos del paciente','data-toggle'=>'tooltip']
          );
       }
     public function getProfesionalurl(){
         return Html::a( $this->profesional->apellido.', '. $this->profesional->nombre,['profesional/view',"id"=> $this->profesional->id]
           ,[    'class' => 'text-success','role'=>'modal-remote','title'=>'Datos del profesional','data-toggle'=>'tooltip']
          );
       }

     public function getTipodocs() {
         return ArrayHelper::map(Tipodoc::find()->all(), 'id','documento');

       }

     /**
       * @return \yii\db\ActiveQuery
	   */
     public function getProcedencia(){
         return $this->hasOne(Procedencia::className(), ['id' => 'id_procedencia']);
     }
    /**
       * @return \yii\db\ActiveQuery
    */
    public function getServicio() {
        return $this->hasOne(Servicio::className(), ['id' => 'id_servicio']);
    }

    /**
     * @return \yii\db\ActiveQuery
    */
    public function getReunionfamiliars(){
        return $this->hasMany(Reunionfamiliar::className(), ['id_solicitud' => 'id']);
    }
    /**
      * @return \yii\db\ActiveQuery
    */

  // HAS MANY
    public function getSolicitudDiagnosticos(){
       return $this->hasMany(SolicitudDiagnostico::className(), ['id_solicitud' => 'id'])
       ->andWhere(['diag_internacion' => false]);

     }
     public function getsolicitudDiagnosticoInternaciones(){
        return $this->hasMany(SolicitudDiagnostico::className(), ['id_solicitud' => 'id'])
        ->andWhere(['diag_internacion' => true]);

      }

      // HAS ONE



     public function getSolicitudDiagnostico(){
        return $this->hasOne(SolicitudDiagnostico::className(), ['id_solicitud' => 'id'])
        ->andWhere(['diag_internacion' => false])
        ->andWhere(['principal' => true]);
      }
      public function getSolicitudDiagnosticoInternacion(){
         return $this->hasOne(SolicitudDiagnostico::className(), ['id_solicitud' => 'id'])
         ->andWhere(['diag_internacion' => true])
         ->andWhere(['principal' => true]);
       }

     public function getSolicitudDiagnosticosInternaciones(){
        return $this->hasMany(SolicitudDiagnostico::className(), ['id_solicitud' => 'id'])
        ->andWhere(['diag_internacion' => true]);
      }


     public function estados() {
       return ArrayHelper::map(Estado::find()->orderBy(['id' => SORT_ASC])->all(), 'id', 'descripcion');

     }
     public function servicios() {
       return ArrayHelper::map(Servicio::find()
               ->all(), 'id','nombre');
     }

     /**
      * @return \yii\db\ActiveQuery
      */
     public function getInternacion() {
       return $this->hasOne(Internacion::className(), ['id_solicitud' => 'id']);
     }
}
