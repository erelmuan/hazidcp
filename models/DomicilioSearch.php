<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Domicilio;

/**
 * DomicilioSearch represents the model behind the search form about `app\models\Domicilio`.
 */
class DomicilioSearch extends Domicilio
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_barrio', 'id_paciente', 'id_provincia', 'id_localidad', 'id_tipodom'], 'integer'],
            [['direccion', 'fechabaja'], 'safe'],
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
        $query = Domicilio::find();

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
            'id_barrio' => $this->id_barrio,
            'id_paciente' => $this->id_paciente,
            'id_provincia' => $this->id_provincia,
            'id_localidad' => $this->id_localidad,
            'id_tipodom' => $this->id_tipodom,
            'fechabaja' => $this->fechabaja,
        ]);

        $query->andFilterWhere(['like', 'direccion', $this->direccion]);

        return $dataProvider;
    }
}
