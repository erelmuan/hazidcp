<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Atencion;

/**
 * AtencionSearch represents the model behind the search form about `app\models\Atencion`.
 */
class AtencionSearch extends Atencion
{
  public $usuario;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_usuario', 'id_tipoconsulta', 'id_respuesta',  'id_servicio'], 'integer'],
            ['fechahora', 'validateDateFormat'],
            [['fechahora', 'usuario', 'personaasesorada', 'detalles', 'vinculo','paciente'], 'safe'],
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
        $query = Atencion::find()->innerJoinWith('usuario', true)
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
            'id_usuario' => $this->id_usuario,
            'id_tipoconsulta' => $this->id_tipoconsulta,
            'id_respuesta' => $this->id_respuesta,
            'id_servicio' => $this->id_servicio,
        ]);
        // Convertir el formato de la fecha a Y-m-d para la consulta
            if (trim($this->fechahora)) {
                $fechahora = \DateTime::createFromFormat('d/m/Y', $this->fechahora);
                if ($fechahora) {
                    $query->andFilterWhere(['DATE(fechahora)' => $fechahora->format('Y-m-d')]);
                }
            }
        $query->andFilterWhere(['ilike', 'personaasesorada', $this->personaasesorada])
            ->andFilterWhere(['ilike', 'detalles', $this->detalles])
            ->andFilterWhere(['ilike', 'vinculo', $this->vinculo])
            ->andFilterWhere(['ilike', 'usuario', $this->usuario])
		         ->andFilterWhere(['ilike', 'paciente', $this->paciente]);

        return $dataProvider;
    }
}
