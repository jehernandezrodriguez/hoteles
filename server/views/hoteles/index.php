<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Hoteles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hoteles-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Hoteles', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nombre',
            'direccion',
            'nit',
            'ciudad_id',
            //'numero_habitaciones',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
