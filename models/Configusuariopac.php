<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "configusuariopac".
 *
 * @property int $id
 * @property int $id_usuario
 * @property bool $pacinternados
 * @property bool $pacsininternacion
 * @property bool $pacalta
 *
 * @property Usuario $usuario
 */
class Configusuariopac extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'configusuariopac';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_usuario'], 'required'],
            [['id_usuario'], 'default', 'value' => null],
            [['id_usuario'], 'integer'],
            [['pacinternados', 'pacsininternacion', 'pacalta'], 'boolean'],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['id_usuario' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_usuario' => 'Id Usuario',
            'pacinternados' => 'Pacientes internados',
            'pacsininternacion' => 'Pacientes sin internacion',
            'pacalta' => 'Pacientes con alta',
        ];
    }

    public function attributeColumns()
    {

      return [
        [
            'class'=>'\kartik\grid\DataColumn',
            'attribute'=>'pacinternados',
            'label'=> 'Pacientes internados',
        ],

        [
            'class'=>'\kartik\grid\DataColumn',
            'attribute'=>'pacsininternacion',
            'label'=> 'Pacientes sin internacion',
        ],
        [
            'class'=>'\kartik\grid\DataColumn',
            'attribute'=>'pacalta',
            'label'=> 'Pacientes con alta',
        ],
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'id_usuario']);
    }

    public static function getSeleccion($id_usuario,)
    {
      return self::find()
        ->select(['pacsininternacion', 'pacinternados', 'pacalta']) // Selección de columnas
        ->andWhere(['id_usuario' => $id_usuario])
        ->asArray()
        ->one(); // Para un solo registro
    }
}
