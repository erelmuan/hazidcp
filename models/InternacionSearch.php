<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Internacion;

/**
 * InternacionSearch represents the model behind the search form about `app\models\Internacion`.
 */
class InternacionSearch extends Internacion
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_tipointernacion', 'id_tipoingreso', 'id_tipoegreso', 'id_solicitud'], 'integer'],
            [['fechahoraingreso', 'fechahoraegreso'], 'safe'],
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
        $query = Internacion::find();

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
            'id_tipointernacion' => $this->id_tipointernacion,
            'fechahoraingreso' => $this->fechahoraingreso,
            'id_tipoingreso' => $this->id_tipoingreso,
            'fechahoraegreso' => $this->fechahoraegreso,
            'id_tipoegreso' => $this->id_tipoegreso,
            'id_solicitud' => $this->id_solicitud,
        ]);

        return $dataProvider;
    }
}
