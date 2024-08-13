<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Detalle;

/**
 * DetalleSearch represents the model behind the search form about `app\models\Detalle`.
 */
class DetalleSearch extends Detalle
{
  public $tipoegreso;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_tipoegreso'], 'integer'],
            [['descripcion','detalle','tipoegreso'], 'safe'],
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
        $query = Detalle::find()->innerJoinWith('tipoegreso', true);

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
            'id_tipoegreso' => $this->id_tipoegreso,
        ]);

        $query->andFilterWhere(['ilike', 'descripcion', $this->descripcion])
        ->andFilterWhere(['ilike', 'tipoegreso.descripcion', $this->tipoegreso]);

        return $dataProvider;
    }
}
