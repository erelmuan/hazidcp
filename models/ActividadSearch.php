<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Actividad;
use app\models\Solicitud;


/**
 * ActividadSearch represents the model behind the search form about `app\models\Actividad`.
 */
class ActividadSearch extends Actividad
{
  public $usuario;
  public $term; // Agrega el atributo "term" al modelo
  public $fecha_desde;
  public $fecha_hasta;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_tipoactividad', 'id_usuario', 'id_paciente'], 'integer'],
            ['fechahora', 'validateDateFormat'],
            [['clasificacion','usuario', 'pacienteint', 'observacion', 'fechahora','fecha_desde','fecha_hasta'], 'safe'],
        ];
    }
    public function validateDateFormat($attribute, $params){
       $date = \DateTime::createFromFormat('d/m/Y', $this->$attribute);
       if (!$date || $date->format('d/m/Y') !== $this->$attribute) {
           $this->addError($attribute, 'Formato incorrecto. Ingrese dd/mm/aaaa');
       }
   }
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Actividad::find()->innerJoinWith('usuario', true)
        ->orderBy(['fechahora' => SORT_DESC]); // Ordenar por fechahora de manera descendente
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'id_tipoactividad' => $this->id_tipoactividad,
            'id_usuario' => $this->id_usuario,
            'id_paciente' => $this->id_paciente,
        ]);
        // Convertir el formato de la fecha a Y-m-d para la consulta
            if (trim($this->fechahora)) {
                $fechahora = \DateTime::createFromFormat('d/m/Y', $this->fechahora);
                if ($fechahora) {
                    $query->andFilterWhere(['DATE(fechahora)' => $fechahora->format('Y-m-d')]);
                }
            }

    $query->andFilterWhere(['clasificacion' => $this->clasificacion ? [$this->clasificacion] : null])
                ->andFilterWhere(['ilike', 'pacienteint', $this->pacienteint])
                ->andFilterWhere(['ilike', 'usuario', $this->usuario])
                ->andFilterWhere(['like', 'observacion', $this->observacion]) ;
                $query->andFilterWhere(['>=', 'fechahora', $this->fecha_desde]);
                $query->andFilterWhere(['<', 'fechahora', $this->fecha_hasta]);

        return $dataProvider;
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
