<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Registrosesion;

/**
 * RegistrosesionSearch represents the model behind the search form about `app\models\Registrosesion`.
 */
class RegistrosesionSearch extends Registrosesion
{
  public $usuario;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_usuario'], 'integer'],
            [['usuario' ,'iniciosesion', 'ip', 'informacionusuario', 'cookie', 'cierresesion'], 'safe'],
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
        $query = Registrosesion::find()->innerJoinWith('usuario', true)
        ->orderBy(['id'=>SORT_DESC]);
;

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
            'iniciosesion' => $this->iniciosesion,
            'cierresesion' => $this->cierresesion,
        ]);

        $query->andFilterWhere(['ilike', 'ip', $this->ip])
            ->andFilterWhere(['ilike', 'usuario', $this->usuario])
            ->andFilterWhere(['ilike', 'informacionusuario', $this->informacionusuario])
            ->andFilterWhere(['ilike', 'cookie', $this->cookie]);

        return $dataProvider;
    }
}
