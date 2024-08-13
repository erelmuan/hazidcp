<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Evolucionindicacion;

/**
 * EvolucionindicacionSearch represents the model behind the search form about `app\models\Evolucionindicacion`.
 */
class EvolucionindicacionSearch extends Evolucionindicacion
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_internacion', 'id_usuario', 'id'], 'integer'],
            [['observacion', 'nombreusuario', 'tiporegistro', 'fechahora','especialidad'], 'safe'],
            ['fechahora', 'validateDateFormat'],
            [['enfermeria'], 'boolean'],
        ];
    }

    public function validateDateFormat($attribute, $params){
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
    public function search($params,$enfermeria,$id_solicitud)
    {
      if($enfermeria){
        $query = Evolucionindicacion::find()->innerJoinWith('internacion', true)
        ->andWhere(['enfermeria' => true, 'internacion.id_solicitud' => $id_solicitud])
        ->orderBy(['fechahora' => SORT_DESC]); // Ordenar por fechahora de manera descendente
      }else {
        $query = Evolucionindicacion::find()->innerJoinWith('internacion', true)
        ->andWhere(['enfermeria' => false, 'internacion.id_solicitud' => $id_solicitud])
        ->orderBy(['fechahora' => SORT_DESC]); // Ordenar por fechahora de manera descendente
      }

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
            'id_internacion' => $this->id_internacion,
            'id_usuario' => $this->id_usuario,
            'id' => $this->id,
            'enfermeria' => $this->enfermeria,
        ]);
        if (trim($this->fechahora)) {
            $fechahora = \DateTime::createFromFormat('d/m/Y', $this->fechahora);
            if ($fechahora) {
                $query->andFilterWhere(['DATE(fechahora)' => $fechahora->format('Y-m-d')]);
            }
        }
        $query->andFilterWhere(['ilike', 'observacion', $this->observacion])
            ->andFilterWhere(['ilike', 'nombreusuario', $this->nombreusuario])
            ->andFilterWhere(['=', 'tiporegistro', $this->tiporegistro])
            ->andFilterWhere(['ilike', 'especialidad', $this->especialidad]);


        return $dataProvider;
    }
}
