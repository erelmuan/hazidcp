<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SolicitudDiagnostico;

/**
 * SolicitudDiagnosticoSearch represents the model behind the search form about `app\models\SolicitudDiagnostico`.
 */
class SolicitudDiagnosticoSearch extends SolicitudDiagnostico
{
  public $codigo;
  public $descripcion;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_diagnostico', 'id_solicitud'], 'integer'],
            [['principal', 'diag_internacion'], 'boolean'],
            [['registro_usuario', 'registro_tiempo' ,'codigo','descripcion'], 'safe'],
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
    public function search($params,$id_solicitud)
    {
        $query = SolicitudDiagnostico::find()->innerJoinWith('diagnostico', true)
        ->andWhere(['id_solicitud'=>$id_solicitud]);

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
            'id_diagnostico' => $this->id_diagnostico,
            'id_solicitud' => $this->id_solicitud,
            'principal' => $this->principal,
            'registro_tiempo' => $this->registro_tiempo,
            'diag_internacion' => $this->diag_internacion,
        ]);
        $query->andFilterWhere(['ilike', 'codigo', $this->codigo]);
        $query->andFilterWhere(['ilike', 'descripcion', $this->descripcion]);

        $query->andFilterWhere(['ilike', 'registro_usuario', $this->registro_usuario]);

        return $dataProvider;
    }
}
