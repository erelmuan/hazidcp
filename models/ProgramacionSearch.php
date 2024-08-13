<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Programacion;

/**
 * ProgramacionSearch represents the model behind the search form about `app\models\Programacion`.
 */
class ProgramacionSearch extends Programacion
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_solicitud', 'id_usuario'], 'integer'],
            [['fecha', 'turno', 'practica'], 'safe'],
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
        $query = Programacion::find();

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
            'id_solicitud' => $this->id_solicitud,
            'id_usuario' => $this->id_usuario,
            'fecha' => $this->fecha,
        ]);

        $query->andFilterWhere(['like', 'turno', $this->turno])
            ->andFilterWhere(['like', 'practica', $this->practica]);

        return $dataProvider;
    }
}
