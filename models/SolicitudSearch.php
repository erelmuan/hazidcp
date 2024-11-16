<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Solicitud;
use app\models\Configusuariopac;


use DateTime;


/**
 * SolicitudSearch represents the model behind the search form about `app\models\Solicitud`.
 */
class SolicitudSearch extends Solicitud
{
  public $paciente;
  public $profesional;
  public $procedencia;
  public $estado;
  public $servicio;
  public $numdocumento;
  public $term; // Agrega el atributo "term" al modelo
  public $id_tipodoc; // Propiedad para paciente.id_tipodoc
  public $fecha_desde;
  public $fecha_hasta;
  public $profesional_acargo;
  public $diagnostico_principal;

    /**
     * @inheritdoc
     */


    public function rules()
    {
        return [
            //tiene que estar aqui para que esten los filtros
            [['id', 'id_paciente',  'id_profesional',  'id_servicio', 'id_estado','id_procedencia','numdocumento'], 'integer'],
            ['fechasolicitud', 'date', 'format' => 'dd/MM/yyyy'],
            [[ 'fecha_desde','fecha_hasta','observacion'], 'safe'],
            [['paciente','profesional','profesional_acargo','procedencia','servicio','estado' ,'numdocumento','direccion', 'barrio','diagnostico_principal'], 'safe'],
            [['id_tipodoc'], 'safe'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function arrayVacios($searchModelAttributes){
        foreach ($searchModelAttributes as $attribute => $value) {
              if ($value !== null) {
                return false;
              }
            }
        return true;
    }

    public function searchConsulta($params ,$query,$dataProvider){

        // Verificar si solo se proporciona la fecha_desde y no los campos numdocumento ni paciente
        if (!$this->validate() || ((empty(trim($this->numdocumento)) && empty($this->paciente))
        && (empty($this->fecha_hasta) && empty($this->fecha_desde)))) {
          $searchModelAttributes = $this->getAttributes();

          if (!$this->arrayVacios($searchModelAttributes) ) {
               $desde = date('d/m/Y', strtotime('-7 days'));
               $query->andWhere(['>=', 'fechasolicitud', $desde])
                  ->orderBy(['id' => SORT_DESC]);
               $this->fecha_desde=$desde;
               $this->fecha_hasta=date('d/m/Y');
          }

        }else {
          if (!empty(trim($this->numdocumento)) || !empty($this->paciente)){
            $query->andFilterWhere(['>=', 'fechasolicitud', $this->fecha_desde]);
            $query->andFilterWhere(['<=', 'fechasolicitud', $this->fecha_hasta]);
          }
            else {
              //tengo que tener un logica de 7 dias entre estos dias
                 if (!empty($this->fecha_desde) && !empty($this->fecha_hasta)) { // A partir de la fecha desde, un máximo de 7 días
                     $fd =DateTime::createFromFormat('d/m/Y', $this->fecha_desde);
                     $fd->modify('+7 days');
                     $fh =DateTime::createFromFormat('d/m/Y', $this->fecha_hasta);
                     $this->fecha_hasta = $fh <= $fd ? $fd->format('d/m/Y') :  $fh->format('d/m/Y') ;
                 } elseif (empty($this->fecha_desde)) { // Un día, el establecido en hasta
                     $this->fecha_desde = $this->fecha_hasta;
                 } else { // Un día, el establecido en desde
                     $this->fecha_hasta = $this->fecha_desde;
                 }
                 $query->andFilterWhere(['>=', 'fechasolicitud', $this->fecha_desde]);
                 $query->andFilterWhere(['<=', 'fechasolicitud', $this->fecha_hasta]);
            }
          }

       return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params,$busqueda )
    {
      $seleccionQuery = Configusuariopac::find()
        ->select(['pacsininternacion', 'pacinternados', 'pacalta']) // Selección de columnas
        ->andWhere(['id_usuario' => Yii::$app->user->id])
        ->asArray()
        ->one(); // Para un solo registro

        // var_dump(  $seleccionQuery);
        // exit();
        $query = Solicitud::find()->innerJoinWith('procedencia', true)
        ->innerJoinWith('paciente')
        ->innerJoinWith('profesional')
        ->innerJoinWith('estado')
        ->innerJoinWith('servicio')
        ->innerJoin('solicitud_diagnostico', 'solicitud_diagnostico.id_solicitud = solicitud.id')
        ->innerJoin('diagnostico', 'diagnostico.id = solicitud_diagnostico.id_diagnostico')
        ->innerJoin('prestador', 'prestador.id = profesional.id_prestador')
        ->leftJoin('internacion', 'internacion.id_solicitud = solicitud.id'); // Unir con la tabla `internacion`
        if ($seleccionQuery['pacalta']) {
            // Agregar condición para pacientes dados de alta (fechahoraegreso no nula)
            $query->orWhere(['IS NOT', 'internacion.fechahoraegreso', null]);
        }

        if ($seleccionQuery['pacinternados']) {
            // Agregar condición para pacientes internados (fechahoraegreso nula)
            $query->orWhere(['IS', 'internacion.fechahoraegreso', null]);
            $query->andWhere(['IS NOT', 'internacion.id_solicitud', null]);

        }

        if ($seleccionQuery['pacsininternacion']) {
            // Agregar condición para solicitudes sin internación (sin registro en internacion)
            $query->orWhere(['internacion.id_solicitud' => null]);
        }


        if($busqueda=="anulado"){
        $query->andWhere(['and','id_estado = 4 ' ]);
        }else {
          $query->andWhere(['and','id_estado <> 4 ' ]);
        }
        $query->andWhere(['and','principal = true' ]);

        $dataProvider = new ActiveDataProvider([
           'query' => $query,

       ]);
    $query->orderBy(['fechasolicitud'=> SORT_DESC ,'id' => SORT_DESC ]);
       $this->load($params);
       if (!$this->validate()) {
           // uncomment the following line if you do not want to return any records when validation fails
           // $query->where('0=1');
           return $dataProvider;
       }

         $dataProvider->setSort([
             'attributes' => [
               'estado','id','fechasolicitud','sexo',
          ]]);

        $this->load($params);


        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'solicitud.id' => $this->id,
        ]) ;

          $query->andFilterWhere(['=', 'fechasolicitud', $this->fechasolicitud]);
          $query->andFilterWhere([  'id_procedencia' => $this->id_procedencia,]);
          $query->andFilterWhere([  'id_servicio' => $this->id_servicio,]);
          $query->andFilterWhere([ "paciente.numdocumento" => trim($this->numdocumento),]);

          $paciente= trim($this->paciente);
        if (is_numeric($paciente)){
            $query->andFilterWhere(["paciente.numdocumento"=>$paciente]);
             }
        else {
            $apellidonombreP = explode(",", $paciente);
            $query->andFilterWhere(['ilike', '("paciente"."apellido")',strtolower(trim($apellidonombreP[0]))]);
            if (isset($apellidonombreP[1])){
              $query->andFilterWhere(['ilike', '("paciente"."nombre")',strtolower(trim($apellidonombreP[1]))]);
            }
        }
        $profesional= trim($this->profesional);
        if (is_numeric($profesional)){
            $query->andFilterWhere(["profesional.matricula"=>$profesional]);
             }
        else {
            $apellidonombreM = explode(",", $profesional);
            $query->andFilterWhere(['ilike', '("prestador"."apellido")',strtolower(trim($apellidonombreM[0]))]);
            if (isset($apellidonombreM[1])){
              $query->andFilterWhere(['ilike', '("prestador"."nombre")',strtolower(trim($apellidonombreM[1]))]);
            }
        }
        $query->andFilterWhere(['paciente.id_tipodoc' => $this->id_tipodoc]);
        $query->andFilterWhere([ "paciente.numdocumento" => trim($this->numdocumento)]);

        $query->andFilterWhere(['ilike', 'observacion', $this->observacion])
        ->andFilterWhere(['ilike', 'solicitud.direccion', $this->direccion])
        ->andFilterWhere(['ilike', 'barrio', $this->barrio])
        ->andFilterWhere(['ilike', 'estado.descripcion', $this->estado])
        ->andFilterWhere(['ilike', 'diagnostico.descripcion', $this->diagnostico_principal])
        ->andFilterWhere(['ilike', 'servicio.nombre', $this->servicio])
        ->andFilterWhere(['ilike', 'procedencia.nombre', $this->procedencia]);
        //Si busqueda tiene el valor "consulta" el metodo search es invocado por la funcion actionConsulta del controlador
        if($busqueda){
          $dataProvider=  $this->searchConsulta($params, $query,$dataProvider);
        }

        return $dataProvider;
    }

    public function getAttributes($names = null, $except = [])
{
    $attributes = parent::getAttributes($names, $except);
    $attributes['fecha_desde'] = $this->fecha_desde;
    $attributes['fecha_hasta'] = $this->fecha_hasta;
    $attributes['numdocumento'] = $this->numdocumento;
    $attributes['paciente'] = $this->paciente;

    return $attributes;
}


public function searchAutocomplete()
{
    // Implementa aquí la lógica de búsqueda específica para el autocompletado
    // Puede ser una consulta a la base de datos, búsqueda en un servicio externo, etc.
    // Devuelve los resultados como un arreglo de objetos o modelos
        $results = Solicitud::find()
            ->innerJoinWith('paciente', true)
            ->andFilterWhere(['ilike', new \yii\db\Expression("CONCAT(paciente.nombre, ' ', paciente.apellido)"), trim($this->term)])
            ->orFilterWhere(['ilike', new \yii\db\Expression("CONCAT(paciente.apellido , ' ',paciente.nombre )"), trim($this->term)])
            ->select('DISTINCT ON (paciente.id) solicitud.*')
            ->orderBy('paciente.id, solicitud.id') // Ordenar según sea necesario
            ->limit(15)
            ->all();
    return $results;
}
}
