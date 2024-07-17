<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Profesional;

/**
 * ProfesionalSearch represents the model behind the search form about `app\models\Profesional`.
 */
class ProfesionalSearch extends Profesional
{

  public $tipodoc;
  public $nombre;
  public $apellido;
  public $numdocumento;
  public $especialidad;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['prestador','apellido', 'nombre', 'numdocumento', 'matricula', 'especialidad'], 'safe'],
          // SCESNARIO //
          [['matricula',],'integer','on'=>'search'],
          [['matricula',],'required','on'=>'search'],
          [['visualizar'], 'boolean'],
          // SCESNARIO //
            [['id', 'id_prestador'], 'integer'],
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
    public function search($params, $mostrar=NULL)
    {
        $query = Profesional::find()->JoinWith('prestador', true)
        ->JoinWith('especialidad');


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

      if (!$this->validate()) {
          // uncomment the following line if you do not want to return any records when validation fails
          // $query->where('0=1');
          return $dataProvider;
      }
        if ($mostrar=="SOLO_VER_PROFESIONALES_ELEGIBLES")
        {
            $visualizar=true;
        }else {
            $visualizar=$this->visualizar;
        }
        $query->andFilterWhere([
            'id' => $this->id,
            'id_prestador' => $this->id_prestador,
            'visualizar' => $visualizar,
        ]);

        $query->andFilterWhere(['ilike', 'apellido', $this->apellido])
            ->andFilterWhere(['ilike', 'nombre', $this->nombre])
            ->andFilterWhere(['ilike', 'numdocumento', $this->numdocumento])
            ->andFilterWhere(['ilike', 'tipodoc.documento', $this->tipodoc])
            ->andFilterWhere(['ilike', 'especialidad.nombre', $this->especialidad])
            ->andFilterWhere(['ilike', 'matricula', $this->matricula]);

        return $dataProvider;
    }
}
