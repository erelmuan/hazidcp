<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Reunionfamiliar;

/**
 * ReunionfamiliarSearch represents the model behind the search form about `app\models\Reunionfamiliar`.
 */
class ReunionfamiliarSearch extends Reunionfamiliar
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_solicitud'], 'integer'],
            [['lugar', 'familiares', 'profesionales', 'detallesreunion', 'fechahora'], 'safe'],
            ['fechahora', 'validateDateFormat'],
            [['aceptanacompañamiento'], 'boolean'],
        ];
    }

    public function validateDateFormat($attribute, $params)
   {
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
    public function search($params,$id_solicitud)
    {
        $query = Reunionfamiliar::find()->andFilterWhere(["id_solicitud"=>$id_solicitud]);

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
            'aceptanacompañamiento' => $this->aceptanacompañamiento,
            'id_solicitud' => $this->id_solicitud,
        ]);
        // Convertir el formato de la fecha a Y-m-d para la consulta
            if (trim($this->fechahora)) {
                $fechahora = \DateTime::createFromFormat('d/m/Y', $this->fechahora);
                if ($fechahora) {
                    $query->andFilterWhere(['DATE(fechahora)' => $fechahora->format('Y-m-d')]);
                }
            }
        $query->andFilterWhere(['ilike', 'lugar', $this->lugar])
            ->andFilterWhere(['ilike', 'familiares', $this->familiares])
            ->andFilterWhere(['ilike', 'profesionales', $this->profesionales])
            ->andFilterWhere(['ilike', 'detallesreunion', $this->detallesreunion]);

        return $dataProvider;
    }
}
