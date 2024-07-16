<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Barrio;

/**
 * BarrioSearch represents the model behind the search form about `app\models\Barrio`.
 */
class BarrioSearch extends Barrio
{
  public $localidad;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_localidad'], 'integer'],
            [['nombre','localidad'], 'safe'],
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

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Barrio::find()->innerJoinWith('localidad', true);

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
            'barrio.id' => $this->id,
            'id_localidad' => $this->id_localidad,
        ]);
        $query->andFilterWhere(['ilike', 'barrio.nombre', $this->nombre])
        ->andFilterWhere(['ilike', 'localidad.nombre', $this->localidad]);

        return $dataProvider;
    }
}
