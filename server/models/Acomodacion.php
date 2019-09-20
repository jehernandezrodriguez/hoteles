<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "acomodacion".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property TipoHabitaciones[] $tipoHabitaciones
 */
class Acomodacion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'acomodacion';
    }
    public static function primaryKey(){
          return ["id"];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoHabitaciones()
    {
        return $this->hasMany(TipoHabitaciones::className(), ['acomodacion_id' => 'id']);
    }
}
