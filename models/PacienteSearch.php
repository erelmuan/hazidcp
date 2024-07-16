<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Paciente;

/**
 * PacienteSearch represents the model behind the search form about `app\models\Paciente`.
 */
class PacienteSearch extends Paciente
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'sexo', 'fechanacimiento', 'apellido', 'hc', 'numdocumento'], 'safe'],
            [['id_nacionalidad', 'id_tipodoc', 'id'], 'integer'],
            ['fechanacimiento', 'date', 'format' => 'dd/MM/yyyy'],

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
        $query = Paciente::find();

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
            'fechanacimiento' => $this->fechanacimiento,
            'id_nacionalidad' => $this->id_nacionalidad,
            'id_tipodoc' => $this->id_tipodoc,
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['ilike', 'nombre', $this->nombre])
            ->andFilterWhere(['ilike', 'sexo', $this->sexo])
            ->andFilterWhere(['ilike', 'apellido', $this->apellido])
            ->andFilterWhere(['like', 'hc', $this->hc])
            ->andFilterWhere(['ilike', 'numdocumento', $this->numdocumento]);

        return $dataProvider;
    }
}
