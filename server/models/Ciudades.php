<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ciudades".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Hoteles[] $hoteles
 */
class Ciudades extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ciudades';
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
    public function getHoteles()
    {
        return $this->hasMany(Hoteles::className(), ['ciudad_id' => 'id']);
    }
}
