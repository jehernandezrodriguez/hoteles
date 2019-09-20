<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hoteles".
 *
 * @property int $id
 * @property string $nombre
 * @property string $direccion
 * @property string $nit
 * @property int $ciudad_id
 * @property int $numero_habitaciones
 *
 * @property HotelHabitacion[] $hotelHabitacions
 * @property Ciudades $ciudad
 */
class Hoteles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hoteles';
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
            [['nombre', 'direccion', 'nit', 'ciudad_id', 'numero_habitaciones'], 'required'],
            ['nombre', 'unique'],
            [['ciudad_id', 'numero_habitaciones'], 'integer'],
            [['nombre'], 'string', 'max' => 200],
            [['direccion'], 'string', 'max' => 255],
            [['nit'], 'string', 'max' => 80],
            [['ciudad_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ciudades::className(), 'targetAttribute' => ['ciudad_id' => 'id']],
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
            'direccion' => 'Direccion',
            'nit' => 'Nit',
            'ciudad_id' => 'Ciudad ID',
            'numero_habitaciones' => 'Numero Habitaciones',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHotelHabitacions()
    {
        return $this->hasMany(HotelHabitacion::className(), ['hotel_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCiudad()
    {
        return $this->hasOne(Ciudades::className(), ['id' => 'ciudad_id']);
    }
}
