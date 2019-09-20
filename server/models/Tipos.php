<?php

namespace app\models;

use Yii;

/**
 * 
 *
 * @property int $id
 * @property string $nombre
 *
 * @property HotelHabitacion[] $hotelHabitacions
 * @property HotelHabitacion[] $hotelHabitacions0
 */
class Tipos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipo_habitaciones';
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
    public function getHotelHabitacions()
    {
        return $this->hasMany(HotelHabitacion::className(), ['habitacion_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHotelHabitacions0()
    {
        return $this->hasMany(HotelHabitacion::className(), ['habitacion_id' => 'id']);
    }
}
