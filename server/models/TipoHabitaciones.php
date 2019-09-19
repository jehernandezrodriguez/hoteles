<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipo_habitaciones".
 *
 * @property int $id
 * @property string $nombre
 * @property int $acomodacion_id
 *
 * @property HotelHabitacion[] $hotelHabitacions
 * @property Acomodacion $acomodacion
 */
class TipoHabitaciones extends \yii\db\ActiveRecord
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
            [['nombre', 'acomodacion_id'], 'required'],
            [['acomodacion_id'], 'integer'],
            [['nombre'], 'string', 'max' => 200],
            [['acomodacion_id'], 'exist', 'skipOnError' => true, 'targetClass' => Acomodacion::className(), 'targetAttribute' => ['acomodacion_id' => 'id']],
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
            'acomodacion_id' => 'Acomodacion ID',
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
    public function getAcomodacion()
    {
        return $this->hasOne(Acomodacion::className(), ['id' => 'acomodacion_id']);
    }
}
