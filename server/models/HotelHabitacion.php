<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hotel_habitacion".
 *
 * @property int $id
 * @property int $habitacion_id
 * @property int $hotel_id
 * @property int $acomodacion_id
 * @property string $cantidad
 *
 * @property TipoHabitaciones $habitacion
 * @property TipoHabitaciones $habitacion0
 * @property Hoteles $hotel
 */
class HotelHabitacion extends \yii\db\ActiveRecord
{
    public $acomodacion;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hotel_habitacion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['habitacion_id', 'hotel_id', 'acomodacion_id', 'cantidad'], 'required'],
            [['habitacion_id', 'hotel_id','cantidad', 'acomodacion_id'], 'integer'],
            [['habitacion_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tipos::className(), 'targetAttribute' => ['habitacion_id' => 'id']],
            [['hotel_id'], 'exist', 'skipOnError' => true, 'targetClass' => Hoteles::className(), 'targetAttribute' => ['hotel_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'habitacion_id' => 'Habitacion ID',
            'hotel_id' => 'Hotel ID',
            'acomodacion_id' => 'Acomodacion ID',
            'cantidad' => 'Cantidad',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHabitacion()
    {
        return $this->hasOne(TipoHabitaciones::className(), ['id' => 'habitacion_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHabitacion0()
    {
        return $this->hasOne(TipoHabitaciones::className(), ['id' => 'habitacion_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHotel()
    {
        return $this->hasOne(Hoteles::className(), ['id' => 'hotel_id']);
    }
}
